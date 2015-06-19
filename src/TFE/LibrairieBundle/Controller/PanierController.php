<?php

namespace TFE\LibrairieBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use TFE\LibrairieBundle\Entity\Commande;
use TFE\LibrairieBundle\Entity\Facture;
use TFE\LibrairieBundle\Entity\Livre;
use TFE\LibrairieBundle\Entity\LivreCommande;
use TFE\LibrairieBundle\Form\CommandeAjoutType;

class PanierController extends Controller
{
    public function ajouterAction(Livre $id, $quantite, Request $request)
    {
        $session = $request->getSession();
        $referer = $request->headers->get('referer');
        $panier = $this->getPanier();

        // On vérifie si on a déjà mis le livre dans le panier
        foreach ($panier as $ligne) {
            if($ligne->getLivre()->getId() == $id->getId())
            {
                $ligne->setQuantite($ligne->getQuantite() + $quantite);
                $session->set('panier', $panier);
                $this->totalPanier();

                return $this->redirect($referer);
            }
        }

        $ligneCommande = new LivreCommande();
        $ligneCommande->setLivre($id);
        $ligneCommande->setQuantite($quantite);
        $ligneCommande->setPrixVenteFinalHtva($id->getPrixTotalHtva());
        $ligneCommande->setTvaVente($id->getTvaTotal());
        $panier->add($ligneCommande);
        $session->set('panier', $panier);
        $this->totalPanier();

        return $this->redirect($referer);
    }

    public function majLigneCommandeAction(Livre $id, Request $request)
    {
        if ($request->isMethod('POST'))
        {
            $quantite = $request->request->get('quantite');
            $panier = $this->getPanier();
            $referer = $request->headers->get('referer');

            // On vérifie si on a déjà mis le livre dans le panier
            foreach ($panier as $ligne) {
                if($ligne->getLivre()->getId() == $id->getId())
                {
                    $ligne->setQuantite($quantite + 0);
                    $request->getSession()->set('panier', $panier);
                    $this->totalPanier();

                    return $this->redirect($referer);
                }
            }

            $ligneCommande = new LivreCommande();
            $ligneCommande->setLivre($id);
            $ligneCommande->setQuantite($quantite + 0);
            $ligneCommande->setPrixVenteFinalHtva($id->getPrixTotalHtva());
            $ligneCommande->setTvaVente($id->getTvaTotal());
            $panier->add($ligneCommande);
            $request->getSession()->set('panier', $panier);
            $this->totalPanier();

            return $this->redirect($referer);
        }

    }

    public function enleverAction($id, Request $request)
    {

        $session = $request->getSession();
        $referer = $request->headers->get('referer');
        $panier = $this->getPanier();

        $panier->remove($id);
        $session->set('panier', $panier);
        $this->totalPanier();

        return $this->redirect($referer);
    }

    public function gestionPanierAction()
    {
        return $this->render('@TFELibrairie/panier/liste.html.twig', array(
                'panier' => $this->getPanier()
            ));
    }

    public function connexionAction(Request $request)
    {
        // Si le visiteur est identifié, on le redirige vers l'accueil
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            //return $this->redirectToRoute('tfe_librairie_accueil:');
        }

        $session = $request->getSession();

        // On vérifie s'il y a des erreurs d'une précédente soumission du formulaire
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('@TFELibrairie/panier/connexion.html.twig', array(
                // Valeur du précédent nom d'utilisateur entré par l'internaute
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            ));
    }

    public function EnvoiPaypalAction(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm(new CommandeAjoutType(), $commande);

        if ($request->isMethod('POST')) {
            if ($form->handleRequest($request)->isValid()) {

                $date = new \DateTime();
                $commande->setNrCommande( uniqid($date->format('y-m-d-')) );
                $commande->setDateCommande($date);
                $utilisateur = $this->getUser();
                $commande->setUtilisateur($utilisateur);
                $commande->setEnAttente(1);
                $commande->setAnnule(0);
                $commande->setEnvoye(0);
                $panier = $this->getPanier();
                $em = $this->getDoctrine()->getManager();

                $em->persist($commande);
                $em->flush();

                foreach($panier as $ligneCommande) {
                    $ligne = new LivreCommande();
                    $ligne->setCommande($commande);
                    $livre = $em->getRepository('TFELibrairieBundle:Livre')->find($ligneCommande->getLivre()->getId());
                    $ligne->setLivre($livre);
                    $ligne->setQuantite($ligneCommande->getQuantite());
                    $ligne->setPrixVenteFinalHtva($ligneCommande->getPrixVenteFinalHtva());
                    $ligne->setTvaVente($ligneCommande->getTvaVente());

                    $livre->setStock($livre->getStock() - $ligneCommande->getQuantite());
                    $livre->setNbrVente($livre->getNbrVente() + $ligneCommande->getQuantite());
                    $em->persist($ligne);
                    $commande->addLivreCommande($ligne);
                }

                $commande->setNrCommande($date->format('Ymd'). $commande->getId());

                // *********** Partie à exporter dans PayPal:ipn, une fois la méthode ipn en place **********

                // On crée la facture
                // Pour le moment, on joue avec l'id de la facture pour générer un numéro de facture unique
                // Peut etre changer pour mettre en place un système basé sur une facturation par année
                $facture = new Facture();
                $facture->setDateFacture(new \DateTime());
                $facture->setCommande($commande);
                $commande->setFacture($facture);
                $em->persist($facture);

                $em->flush();

                // Enregistrement dans le src qui n'est pas accessible depuis l'extérieur
                $this->get('knp_snappy.pdf')->generateFromHtml(
                    $this->renderView('@TFELibrairie/utilitaire/pdf.html.twig', array(
                            'commande'  => $commande
                        )),
                    __DIR__ . '/../Resources/public/Facture/' . $facture->getId() . '.pdf'
                );

                // Envoi d'un mail au client avec la facture générée en attachment
                // On crée la page html qu'on va intégrer dans notre email
                $corpsEmail = $this->renderView('@TFELibrairie/utilitaire/confirmationCommande.html.twig', array(
                        'utilisateur'   => $utilisateur
                    ));

                // Envoi de l'email
                $message = \Swift_Message::newInstance()
                    ->setSubject("Confirmation de commande")
                    ->setFrom('bacinfogestion@gmail.com')
                    ->setTo($utilisateur->getEmail())
                    ->setBody($corpsEmail, 'text/html')
                    ->attach(\Swift_Attachment::fromPath( __DIR__ . '/../Resources/public/Facture/' . $facture->getId() . '.pdf'))
                ;
                $this->get('mailer')->send($message);

                $request->getSession()->set('panier', new ArrayCollection());
                $this->totalPanier();

                // ************************************************************************************************

                //on sauvegarde l'id de la commande en session pour l'utiliser dans la prochaine route
                $request->getSession()->set('idCommande', $commande->getId());
                return $this->redirectToRoute('paypal_index');
            }
        }

        return $this->render('@TFELibrairie/panier/validation.html.twig', array(
                'form'  => $form->createView()
            ));
    }

    /**
     * @return mixed
     */
    private function getPanier()
    {
        $session = $this->get('session');
        // Si pas de variable session 'panier', on en crée une
        if ($session->has('panier') == false)
        {
            $session->set('panier', new ArrayCollection());
            $session->set('totalPanier', 0);
        }

        return $session->get('panier');
    }

    /**
     * @param Request $request
     * @return float
     */
    private function totalPanier()
    {
        $session = $this->get('session');
        $panier = $session->get('panier');
        $total = 0.0;

        foreach($panier as $ligne)
        {
            $total += (($ligne->getPrixVenteFinalHtva() + $ligne->getTvaVente()) * $ligne->getQuantite());
        }

        $session->set('totalPanier', $total);
    }
}
