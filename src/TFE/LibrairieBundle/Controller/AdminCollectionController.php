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

class AdminCollectionController extends Controller
{
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $collections = $em->getRepository('TFELibrairieBundle:Collection')->getListe();

        return $this->render('TFELibrairieBundle:admin/collection:liste.html.twig', array(
            'collections'  => $collections
        ));
    }

    public function ajouterAction(Request $request)
    {
        $collection = new Entity\Collection();
        $form = $this->createForm(new Form\CollectionAjoutType(), $collection);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($collection);
                $em->flush();

                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Collection ajoutée.');
                return $this->redirect($this->generateUrl('admin_collection_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin/collection:ajout.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    public function modifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $collection = $em->getRepository('TFELibrairieBundle:Collection')->find($id);

        if ($collection === null) {
            throw $this->createNotFoundException("La collection ".$id." n'existe pas.");
        }

        $form = $this->createForm(new Form\CollectionModifierType(), $collection);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em->flush();
                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Collection modifiée');
                return $this->redirect($this->generateUrl('admin_collection_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin/collection:modifier.html.twig', array(
            'form'  => $form->createView(),
            'collection' => $collection
        ));
    }

    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $collection = $em->getRepository('TFELibrairieBundle:Collection')->find($id);
        if ($collection === null) {
            throw $this->createNotFoundException("La collection ".$id." n'existe pas.");
        }

        $session = $request->getSession();
        $livres = $collection->getLivres();
        if (count($livres))
        {
            $session->getFlashBag()->add('info', 'Suppression impossible. Collection utilisée par un ou plusieurs livres');
            return $this->redirect($this->generateUrl('admin_collection_liste'));
        }

        $em->remove($collection);
        $em->flush();
        $session->getFlashBag()->add('info', 'Genre supprimé');
        return $this->redirect($this->generateUrl('admin_collection_liste'));
    }
} 