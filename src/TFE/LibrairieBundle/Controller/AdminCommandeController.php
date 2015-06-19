<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminCommandeController extends Controller
{
    public function listeAttenteAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        $em = $this->getDoctrine()->getManager();

        $maxCommandes = 10;
        $commandes_count = $em->getRepository('TFELibrairieBundle:Commande')->countAll();

        $pages_count = ceil($commandes_count / $maxCommandes);

        $pagination = array(
            'page'          => $page,
            'route'         => 'admin_commande_liste_attente',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        if ($pages_count == 0)
        {
        return $this->render('@TFELibrairie/admin/commande/listeAttente.html.twig');
        }

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $commandes = $em->getRepository('TFELibrairieBundle:Commande')->listEnAttente($page, $maxCommandes);

        return $this->render('@TFELibrairie/admin/commande/listeAttente.html.twig', array(
            'commandes'     => $commandes,
            'pagination'    => $pagination
        ));
    }

    public function preparationAction($id)
    {
        if($id < 1) throw $this->createNotFoundException("La page n'existe pas.");

        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('TFELibrairieBundle:Commande')->find($id);

        if($commande === null) throw $this->createNotFoundException("La commande n'existe pas.");

        if ($commande->getEnvoye())
        {
            $this->addFlash('info', 'Cette commande a déjà été envoyée');
            return $this->redirectToRoute('admin_commande_liste_attente');
        }

        $commande->setEnAttente(false);
        $commande->setEnvoye(true);
        $em->flush();
        $this->addFlash('info', 'La commande a bien été traitée');
        return $this->redirectToRoute('admin_commande_liste_attente');
    }
} 