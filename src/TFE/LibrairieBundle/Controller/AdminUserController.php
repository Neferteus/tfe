<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 31-03-15
 * Time: 12:33
 */

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TFE\UserBundle\Entity as Entity;
use TFE\UserBundle\Form as Form;

class AdminUserController extends Controller
{

    /**
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * Gère la page listing
     */
    public function listeUtilisateurActifAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        $em = $this->getDoctrine()->getManager();

        $maxUtilisateurs = 10;
        $utilisateurs_count = $em->getRepository('TFEUserBundle:Utilisateur')->countActif();

        $pages_count = ceil($utilisateurs_count / $maxUtilisateurs);

        $pagination = array(
            'page'          => $page,
            'route'         => 'admin_user_liste_actif',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        if ($pages_count == 0)
        {
            return $this->render('TFELibrairieBundle:admin\utilisateur:listeActif.html.twig', array(
                    'pagination'    => $pagination
                ));
        }

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $utilisateurs = $em->getRepository('TFEUserBundle:Utilisateur')->getListActif($page, $maxUtilisateurs);

        return $this->render('TFELibrairieBundle:admin\utilisateur:listeActif.html.twig', array(
            'utilisateurs'  => $utilisateurs,
            'pagination'    => $pagination
        ));
    }

    public function listeUtilisateurInactifAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();

        $maxUtilisateurs = 2;
        $utilisateurs_count = $em->getRepository('TFEUserBundle:Utilisateur')->countInactif();

        $pages_count = ceil($utilisateurs_count / $maxUtilisateurs);

        $pagination = array(
            'page'          => $page,
            'route'         => 'admin_user_liste_inactif',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        if($pages_count == 0)
        {
            return $this->render('TFELibrairieBundle:admin\utilisateur:listeInactif.html.twig', array(
                'pagination'    => $pagination
            ));
        }

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $utilisateurs = $em->getRepository('TFEUserBundle:Utilisateur')->getListInactif($page, $maxUtilisateurs);

        return $this->render('TFELibrairieBundle:admin\utilisateur:listeInactif.html.twig', array(
            'utilisateurs'  => $utilisateurs,
            'pagination'    => $pagination
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajouterUtilisateurAction(Request $request)
    {
        $utilisateur = new Entity\Utilisateur();
        $form = $this->createForm(new Form\UtilisateurAdminAjoutType(), $utilisateur);

        if($request->isMethod('POST'))
        {
            if($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($utilisateur);

                // On crée un sel pour le cryptage du mot de passe
                $utilisateur->setSalt( hash('sha1', (new \DateTime())->format('d-m-Y H:i:s')) );

                // Crypter le mot de passe via la méthode définie dans security.yml.
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($utilisateur);
                $password = $encoder->encodePassword($form->get('password')->getData(), $utilisateur->getSalt());
                $utilisateur->setPassword($password)
                    ->setInscriptionValide(true)
                    ->setCodeActivation("");

                //On enregistre le changement
                $em->flush();

                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Utilisateur bien enregistré');

                return $this->redirect($this->generateUrl('admin_user_liste_actif'));
            }
        }

        return $this->render('TFEUserBundle:Utilisateur:ajouterAdmin.html.twig', array(
            'form'      => $form->createView()
        ));
    }

    public function voirAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('TFEUserBundle:Utilisateur')->find($id);

        if ($utilisateur == null) {
            throw $this->createNotFoundException("L'utilisateur ".$id." n'existe pas.");
        }

        $form = $this->createForm(new Form\UtilisateurVoirType(), $utilisateur);
        return $this->render('TFEUserBundle:Utilisateur:voir.html.twig', array(
            'form' => $form->createview()
        ));
    }

    public function modifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('TFEUserBundle:Utilisateur')->find($id);

        if ($utilisateur == null) {
            throw $this->createNotFoundException("L'utilisateur ".$id." n'existe pas.");
        }

        $form = $this->createForm(new Form\UtilisateurModifierType(), $utilisateur);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em->flush();
                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Utilisateur modifié');
                return $this->redirect($this->generateUrl('admin_user_liste_actif'));
            }
        }

        return $this->render('TFEUserBundle:Utilisateur:modification.html.twig', array(
            'form' => $form->createview()
        ));
    }

    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('TFEUserBundle:Utilisateur')->find($id);

        if ($utilisateur == null) {
            throw $this->createNotFoundException("L'utilisateur ".$id." n'existe pas.");
        }

        $session = $request->getSession();
        $commandes = $utilisateur->getCommandes();
        if (count($commandes))
        {
            $session->getFlashBag()->add('info', 'Suppression impossible. Le membre a déjà passé une commande.');
            return $this->redirect($this->generateUrl('admin_user_liste_actif'));
        }

        $em->remove($utilisateur);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_user_liste_inactif'));
    }
} 