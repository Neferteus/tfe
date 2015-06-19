<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TFE\LibrairieBundle\Entity\AuteurRecompense;
use TFE\LibrairieBundle\Form\AuteurRecompenseType;

class AdminAuteurRecompenseController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $auteurRecompense = new AuteurRecompense();
        $form = $this->createForm(new AuteurRecompenseType(), $auteurRecompense);

        if ($request->isMethod('POST'))
        {
            if($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($auteurRecompense);
                $em->flush();

                return $this->redirectToRoute('admin_auteur_recompense_ajouter');
            }
        }

        return $this->render('@TFELibrairie/admin/auteurRecompense/ajout.html.twig', array(
                'form'  => $form->createView()
            ));
    }
}