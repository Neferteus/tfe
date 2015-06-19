<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminFactureController extends Controller
{

    public function listeAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $maxFacture = 10;

        $facture_count = $em->getRepository('TFELibrairieBundle:Facture')->countAll();
        $pages_count = ceil($facture_count / $maxFacture);

        if ($pages_count == 0)
        {
            return $this->render('@TFELibrairie/admin/facture/liste.html.twig');
        }

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $pagination = array(
            'page'          => $page,
            'route'         => 'admin_facture_liste',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        $listeFactures = $em->getRepository('TFELibrairieBundle:Facture')->getListe($page, $maxFacture);

        return $this->render('@TFELibrairie/admin/facture/liste.html.twig', array(
                'listeFactures' => $listeFactures,
                'pagination'    => $pagination
            ));
    }

    public function telechargementAction($id)
    {
        $facture = $this->getDoctrine()->getManager()->getRepository('TFELibrairieBundle:Facture')->find($id);

        if ($facture != null)
        {
            $fichier = $id . ".pdf";
            $chemin = __DIR__ . '/../Resources/public/Facture/'; // emplacement du fichier

            $response = new Response();
            $response->setContent(file_get_contents($chemin.$fichier));
            $response->headers->set('Content-Type', 'application/force-download'); // modification du content-type pour forcer le téléchargement (sinon le navigateur internet essaie d'afficher le document)
            $response->headers->set('Content-disposition', 'filename='. $fichier);

            return $response;
        }

    }
} 