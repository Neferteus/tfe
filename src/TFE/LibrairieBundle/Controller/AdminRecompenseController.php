<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TFE\LibrairieBundle\Entity\Recompense;
use TFE\LibrairieBundle\Form\RecompenseAjoutType;
use TFE\LibrairieBundle\Form\RecompenseModifierType;

class AdminRecompenseController extends Controller
{
    public function listeAction($page)
    {
        if ($page < 0)
        {
            throw $this->createNotFoundException("La page n'existe pas");
        }

        $em = $this->getDoctrine()->getManager();

        $maxRecompenses = 10;
        $recompenses_count = $em->getRepository('TFELibrairieBundle:Recompense')->countAll();

        $pages_count = ceil($recompenses_count / $maxRecompenses);

        $pagination = array(
            'page'          => $page,
            'route'         => 'admin_recompense_liste',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        if ($pages_count == 0)
        {
            return $this->render('@TFELibrairie/admin/recompense/liste.html.twig', array(
                    'pagination'    => $pagination
                ));
        }

        if ($page > $pages_count)
        {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $recompenses = $em->getRepository('TFELibrairieBundle:Recompense')->getListeComplete($page, $maxRecompenses);

        return $this->render('@TFELibrairie/admin/recompense/liste.html.twig', array(
                'recompenses'  => $recompenses,
                'pagination'    => $pagination
        ));
    }

    public function ajouterAction(Request $request)
    {
        $recompense = new Recompense();
        $form = $this->createForm(new RecompenseAjoutType(), $recompense);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($recompense);
                $em->flush();

                $this->addFlash('info', 'Collection ajoutée.');
                return $this->redirectToRoute('admin_recompense_liste');
            }
        }

        return $this->render('@TFELibrairie/admin/recompense/ajout.html.twig', array(
                'form'  => $form->createView()
            ));
    }

    public function modifierAction(Recompense $id, Request $request)
    {
        $form = $this->createForm(new RecompenseModifierType(), $id);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('info', 'Récompense modifiée');
                return $this->redirectToRoute('admin_recompense_liste');
            }
        }

        return $this->render('TFELibrairieBundle:admin/recompense:modifier.html.twig', array(
                'form'  => $form->createView(),
                'recompense' => $id
            ));
    }

    public function supprimerAction(Recompense $id)
    {
        if ( count($id->getAuteurRecompenses()) )
        {
            $this->addFlash('info', 'Suppression impossible. Récompense associée à un ou plusieurs auteurs.');
            return $this->redirectToRoute('admin_recompense_liste');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();

        $this->addFlash('info', 'La récompense a bien été supprimée');
        return $this->redirectToRoute('admin_recompense_liste');
    }
}