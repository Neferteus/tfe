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

class AdminFormatController extends Controller
{
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $formats = $em->getRepository('TFELibrairieBundle:Format')->getListe();

        return $this->render('TFELibrairieBundle:admin/format:liste.html.twig', array(
            'formats'  => $formats
        ));
    }

    public function ajouterAction(Request $request)
    {
        $format = new Entity\Format();
        $form = $this->createForm(new Form\FormatAjoutType(), $format);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($format);
                $em->flush();

                return $this->redirect($this->generateUrl('admin_format_liste'));
            }
        }

        return $this->render('@TFELibrairie/admin/format/ajout.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    public function modifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $format = $em->getRepository('TFELibrairieBundle:Format')->find($id);

        if ($format == null) {
            throw $this->createNotFoundException("Le format ".$id." n'existe pas.");
        }

        $form = $this->createForm(new Form\FormatModifierType(), $format);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em->flush();
                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Format modifié');
                return $this->redirect($this->generateUrl('admin_format_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin/format:modifier.html.twig', array(
            'form'      => $form->createView(),
            'format'    => $format
        ));
    }

    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $format = $em->getRepository('TFELibrairieBundle:Format')->find($id);

        if ($format == null) {
            throw $this->createNotFoundException("Le format ".$id." n'existe pas.");
        }

        $session = $request->getSession();
        $livres = $format->getLivres();
        if (count($livres))
        {
            $session->getFlashBag()->add('info', 'Suppression impossible. Format utilisé par un ou plusieurs livres');
            return $this->redirect($this->generateUrl('admin_format_liste'));
        }

        $em->remove($format);
        $em->flush();
        $session->getFlashBag()->add('info', 'Format supprimé');
        return $this->redirect($this->generateUrl('admin_format_liste'));
    }
} 