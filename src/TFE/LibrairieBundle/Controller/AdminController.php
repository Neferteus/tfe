<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $infos = array(
            'utilisateursActifs'    => $em->getRepository('TFEUserBundle:Utilisateur')->countActif(),
            'utilisateursInactifs'  => $em->getRepository('TFEUserBundle:Utilisateur')->countInactif(),
            'utilisateursMois'  => $em->getRepository('TFEUserBundle:Utilisateur')->countMois(),
        );

        return $this->render('TFELibrairieBundle:admin:index.html.twig', array(
                'infos' => $infos
            ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * Gère le menu admin
     */
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();

        $nbUserActifs = $em->getRepository('TFEUserBundle:Utilisateur')->countActif();
        $nbUserInactifs = $em->getRepository('TFEUserBundle:Utilisateur')->countInactif();
        $nbLivres = $em->getRepository('TFELibrairieBundle:Livre')->countAll();
        $nbCommandesAttente = $em->getRepository('TFELibrairieBundle:Commande')->countEnAttente();
        $nbFactures = $em->getRepository('TFELibrairieBundle:Facture')->countAll();
        $nbNewsActif = $em->getRepository('TFELibrairieBundle:News')->countActif();
        $nbNewsInactif = $em->getRepository('TFELibrairieBundle:News')->countInactif();
        $nbAuteurs = $em->getRepository('TFELibrairieBundle:Auteur')->countAll();
        $nbRecompenses = $em->getRepository('TFELibrairieBundle:Recompense')->countAll();

        $listeNb = array(
            'nbUserActifs'          => $nbUserActifs,
            'nbUserInactifs'        => $nbUserInactifs,
            'nbLivres'              => $nbLivres,
            'nbCommandesAttente'    => $nbCommandesAttente,
            'nbFactures'            => $nbFactures,
            'nbNewsActif'           => $nbNewsActif,
            'nbNewsInactif'         => $nbNewsInactif,
            'nbAuteurs'             => $nbAuteurs,
            'nbRecompenses'         => $nbRecompenses
        );

        return $this->render('TFELibrairieBundle:admin:menu.html.twig', array(
            'listeNb'               =>  $listeNb
        ));
    }
}
