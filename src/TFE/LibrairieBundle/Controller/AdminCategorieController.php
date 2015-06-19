<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TFE\LibrairieBundle\Entity as Entity;
use TFE\LibrairieBundle\Form as Form;

class AdminCategorieController extends Controller
{
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('TFELibrairieBundle:Categorie')->getListe();

        return $this->render('TFELibrairieBundle:admin\categorie:liste.html.twig', array(
            'categories'  => $categories
        ));
    }

    public function ajouterAction(Request $request)
    {
        $categorie = new Entity\Categorie();
        $form = $this->createForm(new Form\CategorieAjoutType(), $categorie);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush();

                return $this->redirect($this->generateUrl('admin_categorie_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin\categorie:ajout.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    public function modifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('TFELibrairieBundle:Categorie')->find($id);

        if ($categorie === null) {
            throw $this->createNotFoundException("La catégorie ".$id." n'existe pas.");
        }

        $form = $this->createForm(new Form\CategorieModifierType(), $categorie);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em->flush();
                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Catégorie modifiée');
                return $this->redirect($this->generateUrl('admin_categorie_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin\categorie:modifier.html.twig', array(
            'form'  => $form->createView(),
            'categorie' => $categorie
        ));
    }

    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('TFELibrairieBundle:Categorie')->find($id);

        if (empty($categorie)) {
            throw $this->createNotFoundException("La catégorie ".$id." n'existe pas.");
        }

        $session = $request->getSession();
        $livres = $categorie->getLivres();
        if (count($livres))
        {
            $session->getFlashBag()->add('info', 'Suppression impossible. Catégorie utilisée par un ou plusieurs livres');
            return $this->redirect($this->generateUrl('admin_categorie_liste'));
        }

        $em->remove($categorie);
        $em->flush();
        $session->getFlashBag()->add('info', 'Catégorie supprimée');
        return $this->redirect($this->generateUrl('admin_categorie_liste'));
    }
} 