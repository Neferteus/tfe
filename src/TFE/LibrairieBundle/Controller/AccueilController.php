<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teteAffiches = $em->getRepository('TFELibrairieBundle:Livre')->getListeAffiche();
        $teteVentes = $em->getRepository('TFELibrairieBundle:Livre')->getListeBestSale();
        $aVenir = $em->getRepository('TFELibrairieBundle:Livre')->getListeNouveau();
        $listeNews = $em->getRepository('TFELibrairieBundle:News')->getAllNewsWithUser();
        $promotion = $em->getRepository('TFELibrairieBundle:Livre')->getPromotion();

        return $this->render('TFELibrairieBundle:accueil:index.html.twig', array(
                'teteAffiche'   => $teteAffiches,
                'teteVente'     => $teteVentes,
                'aVenir'        => $aVenir,
                'listeNews'     => $listeNews,
                'promotion'     => $promotion
            ));
    }

    public function aboutUsAction()
    {
        return $this->render('@TFELibrairie/accueil/aboutUs.html.twig');
    }

    public function contactAction()
    {
        return $this->render('@TFELibrairie/accueil/contact.html.twig');
    }

    public function cgvAction()
    {
        return $this->render('@TFELibrairie/legal/cgv.html.twig');
    }

    public function infosPersonnellesAction()
    {
        return $this->render('@TFELibrairie/legal/infosPersonnelles.html.twig');
    }

    public function cookiesPublicitésAction()
    {
        return $this->render('@TFELibrairie/legal/cookies.html.twig');
    }
}
