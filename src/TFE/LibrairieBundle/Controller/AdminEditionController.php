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

class AdminEditionController extends Controller
{
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $editions = $em->getRepository('TFELibrairieBundle:Edition')->getListe();

        return $this->render('TFELibrairieBundle:admin/edition:liste.html.twig', array(
            'editions'  => $editions
        ));
    }

    public function ajouterAction(Request $request)
    {
        $edition = new Entity\Edition();
        $form = $this->createForm(new Form\EditionAjoutType(), $edition);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($edition);
                $em->flush();

                $session = $request->getSession();
                $session->getFlashBag()->add('info', "Maison d'édition ajoutée.");
                return $this->redirect($this->generateUrl('admin_edition_liste'));
            }
        }

        return $this->render('@TFELibrairie/admin/edition/ajout.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    public function modifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $edition = $em->getRepository('TFELibrairieBundle:Edition')->find($id);

        if ($edition === null) {
            throw $this->createNotFoundException("La maison d'édition ".$id." n'existe pas.");
        }

        $form = $this->createForm(new Form\EditionModifierType(), $edition);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em->flush();
                $session = $request->getSession();
                $session->getFlashBag()->add('info', "Maison d'édition modifiée");
                return $this->redirect($this->generateUrl('admin_edition_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin/edition:modifier.html.twig', array(
            'form'  => $form->createView(),
            'edition' => $edition
        ));
    }

    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $edition = $em->getRepository('TFELibrairieBundle:Edition')->find($id);

        if ($edition === null) {
            throw $this->createNotFoundException("La maison d'édition ".$id." n'existe pas.");
        }

        $session = $request->getSession();
        $livres = $edition->getLivres();
        if (count($livres))
        {
            $session->getFlashBag()->add('info', "Suppression impossible. Maison d'édition utilisé par un ou plusieurs livres");
            return $this->redirect($this->generateUrl('admin_edition_liste'));
        }

        $em->remove($edition);
        $em->flush();
        $session->getFlashBag()->add('info', "Maison d'édition supprimée");
        return $this->redirect($this->generateUrl('admin_edition_liste'));
    }
} 