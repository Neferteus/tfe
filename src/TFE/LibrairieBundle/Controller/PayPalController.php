<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PayPalController extends Controller
{
    public function indexAction(Request $request)
    {
        //On récupère la commande via l'id en session
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('TFELibrairieBundle:Commande')->find($request->getSession()->get('idCommande'));

        return $this->render('@TFELibrairie/paypal/index.html.twig', array(
                'commande'  => $commande
            ));
    }

    public function succesAction(Request $request)
    {
        //On retire la variable session idCommande
        $request->getSession()->remove('idCommande');

        return $this->render('@TFELibrairie/paypal/succes.html.twig');
    }

    public function cancelAction(Request $request)
    {
        //On récupère la commande via l'id en session
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('TFELibrairieBundle:Commande')->find($request->getSession()->get('idCommande'));

        //On retire la variable session idCommande
        $request->getSession()->remove('idCommande');

        //On passe la commande en annulé
        $commande->setAnnule(1);

        return $this->render('@TFELibrairie/paypal/cancel.html.twig');
    }

    // ********** Méthode à travailler **********

    public function ipnAction(Request $request)
    {
        return $this->render('@TFELibrairie/paypal/ipn.html.twig');
    }
} 