<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TFE\LibrairieBundle\Entity\News;
use TFE\LibrairieBundle\Form\NewsAjouterType;
use TFE\LibrairieBundle\Form\NewsModifierType;

class NewsController extends Controller
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
            return $this->render('@TFELibrairie/news/liste.html.twig');
        }

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $pagination = array(
            'page'          => $page,
            'route'         => 'news_liste_valide',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        $listeNews = $em->getRepository('TFELibrairieBundle:News')->getListeValide($page, $maxNews);

        return $this->render('@TFELibrairie/news/liste.html.twig', array(
                'listeNews'     => $listeNews,
                'pagination'    => $pagination
            ));
    }

    public function mesNewsAction($id, $page)
    {
        if ($page < 1 || $id < 1)
        {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TFEUserBundle:Utilisateur')->find($id);

        if($user == null)
        {
            throw $this->createNotFoundException("L'utilisateur n'existe pas.");
        }

        $news_count = $em->getRepository('TFELibrairieBundle:News')->countAllById($id);
        $maxNews = 5;
        $pages_count = ceil($news_count / $maxNews);

        if ($pages_count == 0)
        {
            return $this->render('@TFELibrairie/news/perso.html.twig');
        }

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $pagination = array(
            'page'          => $page,
            'route'         => 'news_auteur',
            'pages_count'   => $pages_count,
            'route_params'  => array(),
            'utilisateur'   => $id
        );

        $listeNews = $em->getRepository('TFELibrairieBundle:News')->getListePerso($page, $maxNews, $id);

        return $this->render('@TFELibrairie/news/perso.html.twig', array(
                'listeNews'    => $listeNews,
                'pagination'    => $pagination
            ));
    }

    public function ajouterAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(new NewsAjouterType(), $news);

        if($request->isMethod('POST'))
        {
            if($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $em->persist($news);
                $news->setDateNews(new \DateTime());
                $news->setValide(false);
                $news->setAccueil(false);
                $news->setUtilisateur($this->get('security.context')->getToken()->getUser());
                $em->flush();

                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'News ajoutée.');
                return $this->redirect($this->generateUrl('news_auteur', array('id' => $news->getUtilisateur()->getId())));
            }
        }

        return $this->render('@TFELibrairie/news/ajout.html.twig', array(
                'form'  => $form->createView()
            ));
    }

    public function voirAction($id)
    {
        if ($id < 1) {
            throw $this->createNotFoundException("La page " . $id . " n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('TFELibrairieBundle:News')->getNewsWithUser($id);

        if ($news == null)
        {
            throw $this->createNotFoundException("La news " . $id . " n'existe plus.");
        }

        return $this->render('@TFELibrairie/news/voir.html.twig', array(
                'news'  => $news
            ));
    }

    public function modifierAction($id, Request $request)
    {
        if ($id < 1) {
            throw $this->createNotFoundException("La page " . $id . " n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('TFELibrairieBundle:News')->getNewsWithUser($id);

        if ($news == null)
        {
            throw $this->createNotFoundException("La news " . $id . " n'existe plus.");
        }

        $form = $this->createForm(new NewsModifierType(), $news);

        if($request->isMethod('POST'))
        {
            if($form->handleRequest($request)->isValid())
            {
                $news->setValide(false);
                $em->flush();

                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'News modifiée.');
                return$this->redirect($this->generateUrl('news_auteur', array('id' => $news->getUtilisateur()->getId())));
            }
        }

        return $this->render('TFELibrairieBundle:news:modifier.html.twig', array(
                'form'  => $form->createView()
            ));
    }

    public function supprimerAction($id, Request $request)
    {
        if ($id < 1) {
            throw $this->createNotFoundException("La page " . $id . " n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('TFELibrairieBundle:News')->getNewsWithUser($id);

        if ($news == null)
        {
            throw $this->createNotFoundException("La news " . $id . " n'existe plus.");
        }

        $idUser = $news->getUtilisateur()->getId();
        $em->remove($news);
        $em->flush();

        $session = $request->getSession();
        $session->getFlashBag()->add('info', 'News supprimée.');
        return $this->redirect($this->generateUrl('news_auteur', array('id' => $idUser)));
    }
} 