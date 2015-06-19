<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TFE\LibrairieBundle\Entity\Commentaire;
use TFE\LibrairieBundle\Entity\LivreCommande;
use TFE\LibrairieBundle\Entity\Note;
use TFE\LibrairieBundle\Form as Form;

class LivreController extends Controller
{
    public function infoAction($id, Request $request)
    {
        if ($id < 1) {
            throw $this->createNotFoundException("La page " . $id . " n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $livre = $em->getRepository('TFELibrairieBundle:Livre')->getLivreCompletParId($id);

        if ($livre === null)
        {
            throw $this->createNotFoundException("La news " . $id . " n'existe plus.");
        }

        $commentaire = new Commentaire();
        $formCommentaire = $this->createForm(new Form\CommentaireAjoutType(), $commentaire);

        $note = new Note();
        $utilisateur = $this->get('security.token_storage')->getToken()->getUser();

        // Si l'utilisateur a déjà mis une note, on va associer la note à l'objet
        $noteExist = $em->getRepository('TFELibrairieBundle:Note')->noteExist($livre, $utilisateur);
        if ($noteExist !== null)
        {
            $note->setEtoile($noteExist->getEtoile());
        }

        //Pour afficher la quantité de livre déja présente dans le panier
        $quantite = 0;
        if ($request->getSession()->has('panier'))
        {
            $panier = $request->getSession()->get('panier');
            foreach ($panier as $ligne) {
                if($ligne->getLivre()->getId() == $livre->getId())
                {
                    $quantite = $ligne->getQuantite();
                }
            }
        }

        $formNote = $this->createForm(new Form\NoteAjoutType(), $note);

        if($request->isMethod('POST'))
        {
            if ($request->request->has($formCommentaire->getName()))
            {
                if($formCommentaire->handleRequest($request)->isValid())
                {
                    $em->persist($commentaire);
                    $commentaire->setUtilisateur($this->get('security.token_storage')->getToken()->getUser());
                    $commentaire->setLivre($livre);
                    $commentaire->setBlocageCom(false);
                    $commentaire->setDateCommentaire(new \DateTime());
                    $em->flush();

                    $this->addFlash('commentaire', 'Commentaire ajouté.');
                    return $this->redirectToRoute('livre_info', array('id' => $id));
                }
            }

            if ($request->request->has($formNote->getName()))
            {
                if($formNote->handleRequest($request)->isValid())
                {
                    //$utilisateur = $this->get('security.token_storage')->getToken()->getUser();
                    $noteExist = $em->getRepository('TFELibrairieBundle:Note')->noteExist($livre, $utilisateur);

                    if ($noteExist !== null)
                    {
                        $noteExist->setEtoile($formNote->get('etoile')->getData());
                        $em->flush();

                        $this->addFlash('note', 'Note modifiée.');
                        return $this->redirectToRoute('livre_info', array('id' => $id));
                    }

                    $em->persist($note);
                    $note->setLivre($livre);
                    $note->setUtilisateur($utilisateur);
                    $note->setBlocage(false);
                    $em->flush();

                    $this->addFlash('note', 'Note ajoutée.');
                    return $this->redirectToRoute('livre_info', array('id' => $id));
                }
            }
        }

        return $this->render('@TFELibrairie/livre/voir.html.twig', array(
                'livre'         => $livre,
                'formCom'       => $formCommentaire->createView(),
                'formNote'      => $formNote->createView(),
                'noteExiste'    => $noteExist,
                'quantite'      =>$quantite
            ));
    }

    public function promoInfoAction($id, Request $request)
    {
        if ($id < 1) {
            throw $this->createNotFoundException("La page " . $id . " n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $livre = $em->getRepository('TFELibrairieBundle:Livre')->getLivreCompletParId($id);

        if ($livre === null)
        {
            throw $this->createNotFoundException("La news " . $id . " n'existe plus.");
        }

        $commentaire = new Commentaire();
        $formCommentaire = $this->createForm(new Form\CommentaireAjoutType(), $commentaire);

        $note = new Note();
        $utilisateur = $this->get('security.token_storage')->getToken()->getUser();

        // Si l'utilisateur a déjà mis une note, on va associer la note à l'objet
        $noteExist = $em->getRepository('TFELibrairieBundle:Note')->noteExist($livre, $utilisateur);
        if ($noteExist !== null)
        {
            $note->setEtoile($noteExist->getEtoile());
        }

        //Pour afficher la quantité de livre déja présente dans le panier
        $quantite = 0;
        if ($request->getSession()->has('panier'))
        {
            $panier = $request->getSession()->get('panier');
            foreach ($panier as $ligne) {
                if($ligne->getLivre()->getId() == $livre->getId())
                {
                    $quantite = $ligne->getQuantite();
                }
            }
        }

        $formNote = $this->createForm(new Form\NoteAjoutType(), $note);

        if($request->isMethod('POST'))
        {
            if ($request->request->has($formCommentaire->getName()))
            {
                if($formCommentaire->handleRequest($request)->isValid())
                {
                    $em->persist($commentaire);
                    $commentaire->setUtilisateur($this->get('security.token_storage')->getToken()->getUser());
                    $commentaire->setLivre($livre);
                    $commentaire->setBlocageCom(false);
                    $commentaire->setDateCommentaire(new \DateTime());
                    $em->flush();

                    $this->addFlash('commentaire', 'Commentaire ajouté.');
                    return $this->redirectToRoute('livre_info_promo', array('id' => $id));
                }
            }

            if ($request->request->has($formNote->getName()))
            {
                if($formNote->handleRequest($request)->isValid())
                {
                    //$utilisateur = $this->get('security.token_storage')->getToken()->getUser();
                    $noteExist = $em->getRepository('TFELibrairieBundle:Note')->noteExist($livre, $utilisateur);

                    if ($noteExist !== null)
                    {
                        $noteExist->setEtoile($formNote->get('etoile')->getData());
                        $em->flush();

                        $this->addFlash('note', 'Note modifiée.');
                        return $this->redirectToRoute('livre_info_promo', array('id' => $id));
                    }

                    $em->persist($note);
                    $note->setLivre($livre);
                    $note->setUtilisateur($utilisateur);
                    $note->setBlocage(false);
                    $em->flush();

                    $this->addFlash('note', 'Note ajoutée.');
                    return $this->redirectToRoute('livre_info_promo', array('id' => $id));
                }
            }
        }

        return $this->render('@TFELibrairie/livre/promoVoir.html.twig', array(
                'livre'         => $livre,
                'formCom'       => $formCommentaire->createView(),
                'formNote'      => $formNote->createView(),
                'noteExiste'    => $noteExist,
                'quantite'      =>$quantite
            ));
    }

    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recherche = $request->request->get('recherche');
        $livres = null;

        /* *** Pour limiter le nombre de caractères à entrer pour lancer une recherche ***
        if( strlen(trim($recherche)) > 3 )
        {
            $livres = $em->getRepository('TFELibrairieBundle:Livre')->listeRecherche($recherche);
            return $this->render('@TFELibrairie/catalogue/recherche.html.twig', array(
                    'livres'    => $livres
                ));
        }
        */

        $livres = $em->getRepository('TFELibrairieBundle:Livre')->listeRecherche($recherche);
        return $this->render('@TFELibrairie/catalogue/recherche.html.twig', array(
                'livres'    => $livres
            ));
    }
} 