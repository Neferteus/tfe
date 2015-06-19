<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CatalogueController extends Controller
{
    public function accueilAction($page, $id)
    {
        if ($page < 1 || $id < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $maxLivres = 10;

        $categorie = $em->getRepository('TFELibrairieBundle:Categorie')->find($id);

        if($categorie == null) {
            $livres_count = $em->getRepository('TFELibrairieBundle:Livre')->countAll();
            $pages_count = ceil($livres_count / $maxLivres);
            $livres = $em->getRepository('TFELibrairieBundle:Livre')->getListeComplete($page, $maxLivres);
        }else {
            $livres_count = $em->getRepository('TFELibrairieBundle:Livre')->countAllById($id);
            $pages_count = ceil($livres_count / $maxLivres);
            $livres = $em->getRepository('TFELibrairieBundle:Livre')->getListeCompleteById($page, $maxLivres, $id);
        }

        $pagination = array(
            'page'          => $page,
            'route'         => 'catalogue_accueil',
            'pages_count'   => $pages_count,
            'route_params'  => array(),
            'categorie'     => $id
        );

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $listeGenre = $em->getRepository('TFELibrairieBundle:Genre')->getListeAvecCategorie();

        return $this->render('@TFELibrairie/catalogue/accueil.html.twig', array(
                'livres'        => $livres,
                'listeGenre'    => $listeGenre,
                'pagination'    => $pagination
            ));
    }

    public function promoAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        $em = $this->getDoctrine()->getManager();

        $maxLivres = 1;
        $livres_count = $em->getRepository('TFELibrairieBundle:Livre')->countPromo();

        $pages_count = ceil($livres_count / $maxLivres);

        $pagination = array(
            'page'          => $page,
            'route'         => 'catalogue_promotion',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        if ($pages_count == 0)
        {
            return $this->render('@TFELibrairie/catalogue/promo.html.twig', array(
                    'pagination'    => $pagination
                ));
        }

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $livres = $em->getRepository('TFELibrairieBundle:Livre')->getListePromo($page, $maxLivres);

        return $this->render('@TFELibrairie/catalogue/promo.html.twig', array(
                'livres'  => $livres,
                'pagination'    => $pagination
            ));
    }
} 