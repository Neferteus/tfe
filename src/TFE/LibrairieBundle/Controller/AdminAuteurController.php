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
use TFE\LibrairieBundle\Entity as Entity;
use TFE\LibrairieBundle\Form as Form;

class AdminAuteurController extends Controller
{

    public function listeAction($page)
    {
        if ($page < 1)
        {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }
        $em = $this->getDoctrine()->getManager();

        $maxAuteurs = 10;
        $auteurs_count = $em->getRepository('TFELibrairieBundle:Auteur')->countAll();

        $pages_count = ceil($auteurs_count / $maxAuteurs);

        $pagination = array(
            'page'  => $page,
            'route' => 'admin_auteur_liste',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        if ($pages_count == 0)
        {
            return $this->render('TFELibrairieBundle:admin/auteur:liste.html.twig', array(
                    'pagination'    => $pagination
                ));
        }

        if ($page > $pages_count)
        {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $auteurs = $em->getRepository('TFELibrairieBundle:Auteur')->getListe($page, $maxAuteurs);

        return $this->render('TFELibrairieBundle:admin/auteur:liste.html.twig', array(
                'auteurs'        => $auteurs,
                'pagination'    => $pagination
        ));
    }

    public function ajouterAction(Request $request)
    {
        $auteur = new Entity\Auteur();
        $form = $this->createForm(new Form\AuteurAjoutType(), $auteur);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($auteur);
                $em->flush();

                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Auteur ajouté');
                return $this->redirect($this->generateUrl('admin_auteur_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin/auteur:ajout.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    public function modifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $auteur = $em->getRepository('TFELibrairieBundle:Auteur')->find($id);

        if ($auteur == null) {
            throw $this->createNotFoundException("L'auteur ".$id." n'existe pas.");
        }

        $form = $this->createForm(new Form\AuteurModifierType(), $auteur);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em->flush();
                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Auteur modifié');
                return $this->redirect($this->generateUrl('admin_auteur_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin/auteur:modifier.html.twig', array(
            'form'  => $form->createView(),
            'auteur' => $auteur
        ));
    }

    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $auteur = $em->getRepository('TFELibrairieBundle:Auteur')->find($id);

        if ($auteur == null) {
            throw $this->createNotFoundException("L'auteur ".$id." n'existe pas.");
        }

        $session = $request->getSession();
        $livres = $auteur->getLivres();
        if (count($livres))
        {
            $session->getFlashBag()->add('info', 'Suppression impossible. Auteur utilisé par un ou plusieurs livres');
            return $this->redirect($this->generateUrl('admin_auteur_liste'));
        }

        $em->remove($auteur);
        $em->flush();
        $session->getFlashBag()->add('info', 'Auteur supprimé');
        return $this->redirect($this->generateUrl('admin_auteur_liste'));
    }

} 