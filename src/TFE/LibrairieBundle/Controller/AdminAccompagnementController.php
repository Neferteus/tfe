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

class AdminAccompagnementController extends Controller
{
    public function listeAction($page)
    {
        if ($page < 1)
        {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }
        $em = $this->getDoctrine()->getManager();

        $maxAccompagnements = 10;
        $accompagnements_count = $em->getRepository('TFELibrairieBundle:Accompagnement')->countAll();
        $pages_count = ceil($accompagnements_count / $maxAccompagnements);

        $pagination = array(
            'page'          => $page,
            'route'         => 'admin_accompagnement_liste',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        if ($pages_count == 0)
        {
            return $this->render('TFELibrairieBundle:admin/accompagnement:liste.html.twig', array(
                    'pagination'    => $pagination
                ));
        }

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $accompagnements = $em->getRepository('TFELibrairieBundle:Accompagnement')->getListe($page, $maxAccompagnements);

        return $this->render('TFELibrairieBundle:admin/accompagnement:liste.html.twig', array(
                'accompagnements'   => $accompagnements,
                'pagination'        => $pagination
        ));
    }

    public function ajouterAction(Request $request)
    {
        $accompagnement = new Entity\Accompagnement();
        $form = $this->createForm(new Form\AccompagnementAjoutType(), $accompagnement);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($accompagnement);
                $em->flush();

                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Accompagnement ajouté');
                return $this->redirect($this->generateUrl('admin_accompagnement_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin/accompagnement:ajout.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    public function modifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $accompagnement = $em->getRepository('TFELibrairieBundle:Accompagnement')->find($id);

        if ($accompagnement == null) {
            throw $this->createNotFoundException("Le genre ".$id." n'existe pas.");
        }

        $form = $this->createForm(new Form\AccompagnementModifierType(), $accompagnement);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em->flush();
                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Accompagnement modifié');
                return $this->redirect($this->generateUrl('admin_accompagnement_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin/accompagnement:modifier.html.twig', array(
            'form'  => $form->createView(),
            'accompagnement' => $accompagnement
        ));
    }

    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $accompagnement = $em->getRepository('TFELibrairieBundle:Accompagnement')->find($id);

        if ($accompagnement == null) {
            throw $this->createNotFoundException("L'accompagnement ".$id." n'existe pas.");
        }

        $session = $request->getSession();
        $livres = $accompagnement->getLivres();
        if (count($livres))
        {
            $session->getFlashBag()->add('info', 'Suppression impossible. Accompagnement utilisé par un ou plusieurs livres');
            return $this->redirect($this->generateUrl('admin_accompagnement_liste'));
        }

        $em->remove($accompagnement);
        $em->flush();
        $session->getFlashBag()->add('info', 'Accompagnement supprimé');
        return $this->redirect($this->generateUrl('admin_accompagnement_liste'));
    }
} 