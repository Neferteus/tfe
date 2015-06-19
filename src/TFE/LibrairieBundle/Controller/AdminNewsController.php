<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TFE\UserBundle\Entity as Entity;
use TFE\UserBundle\Form as Form;

class AdminNewsController extends Controller
{

    public function listeValideAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $maxNews = 5;

        $news_count = $em->getRepository('TFELibrairieBundle:News')->countActif();
        $pages_count = ceil($news_count / $maxNews);

        if ($pages_count == 0)
        {
            return $this->render('@TFELibrairie/admin/news/listeActif.html.twig');
        }

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $pagination = array(
            'page'          => $page,
            'route'         => 'admin_news_liste_valide',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        $listeNews = $em->getRepository('TFELibrairieBundle:News')->getListeValide($page, $maxNews);

        return $this->render('@TFELibrairie/admin/news/listeActif.html.twig', array(
                'listeNews'     => $listeNews,
                'pagination'    => $pagination
            ));
    }

    public function listeNonValideAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $maxNews = 5;

        $news_count = $em->getRepository('TFELibrairieBundle:News')->countInactif();
        $pages_count = ceil($news_count / $maxNews);

        if ($pages_count == 0)
        {
            return $this->render('@TFELibrairie/admin/news/listeInactif.html.twig');
        }

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $pagination = array(
            'page'          => $page,
            'route'         => 'admin_news_liste_invalide',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        $listeNews = $em->getRepository('TFELibrairieBundle:News')->getListeInvalide($page, $maxNews);

        return $this->render('@TFELibrairie/admin/news/listeInactif.html.twig', array(
                'listeNews'     => $listeNews,
                'pagination'    => $pagination
            ));
    }

    public function voirActifAction($id)
    {
        if ($id < 1) {
            throw $this->createNotFoundException("La page " . $id . " n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('TFELibrairieBundle:News')->getNewsWithUser($id);

        if ($news === null)
        {
            throw $this->createNotFoundException("La news " . $id . " n'existe plus.");
        }

        return $this->render('@TFELibrairie/admin/news/voirActif.html.twig', array(
                'news'  => $news
            ));
    }

    public function voirInactifAction($id)
    {
        if ($id < 1) {
            throw $this->createNotFoundException("La page " . $id . " n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('TFELibrairieBundle:News')->getNewsWithUser($id);

        if ($news === null)
        {
            throw $this->createNotFoundException("La news " . $id . " n'existe plus.");
        }

        return $this->render('@TFELibrairie/admin/news/voirInactif.html.twig', array(
                'news'  => $news
            ));
    }

    public function changerValidationAction($id)
    {
        if ($id < 1) {
            throw $this->createNotFoundException("La page " . $id . " n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('TFELibrairieBundle:News')->getNewsWithUser($id);

        if ($news === null)
        {
            throw $this->createNotFoundException("La news " . $id . " n'existe plus.");
        }

        if ($news->getValide())
        {
            $news->setValide(false);
            $em->flush();
            return $this->redirectToRoute('admin_news_liste_valide');
        }

        $news->setValide(true);
        $em->flush();
        return $this->redirectToRoute('admin_news_liste_invalide');
    }
} 