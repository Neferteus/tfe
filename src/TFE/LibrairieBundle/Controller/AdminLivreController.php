<?php

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TFE\LibrairieBundle\Entity as Entity;
use TFE\LibrairieBundle\Form as Form;

class AdminLivreController extends Controller
{
    public function listeAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        $em = $this->getDoctrine()->getManager();

        $maxLivres = 10;
        $livres_count = $em->getRepository('TFELibrairieBundle:Livre')->countAll();

        $pages_count = ceil($livres_count / $maxLivres);

        $pagination = array(
            'page'          => $page,
            'route'         => 'admin_livre_liste',
            'pages_count'   => $pages_count,
            'route_params'  => array()
        );

        if ($pages_count == 0)
        {
            return $this->render('TFELibrairieBundle:admin\livre:liste.html.twig', array(
                'pagination'    => $pagination
            ));
        }

        if ($page > $pages_count) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $livres = $em->getRepository('TFELibrairieBundle:Livre')->getListeComplete($page, $maxLivres);

        return $this->render('TFELibrairieBundle:admin\livre:liste.html.twig', array(
            'livres'  => $livres,
            'pagination'    => $pagination
        ));
    }

    public function ajouterAction(Request $request)
    {
        $livre = new Entity\Livre();
        $form = $this->createForm(new Form\LivreAjoutType(), $livre, array(
                'em' =>$this->getDoctrine()->getManager()
            ));

        if($request->isMethod('POST'))
        {
            if($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $em->persist($livre);
                $livre->upload();
                $em->flush();

                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Livre ajouté');
                return $this->redirect($this->generateUrl('admin_livre_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin/livre:ajout.html.twig', array(
            'form'      => $form->createView()
        ));
    }

    public function modifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $livre = $em->getRepository('TFELibrairieBundle:Livre')->find($id);

        if ($livre == null) {
            throw $this->createNotFoundException("Le livre ".$id." n'existe pas.");
        }

        $form = $this->createForm(new Form\LivreModifierType(), $livre, array(
                'em' =>$this->getDoctrine()->getManager()
            ));

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em->persist($livre);

                $livre->upload();
                $livre->videCachePhoto();
                $em->flush();

                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Livre modifié.');
                return $this->redirect($this->generateUrl('admin_livre_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin/livre:modifier.html.twig', array(
                'form'  => $form->createview(),
                'livre' => $livre
        ));
    }

    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $livre = $em->getRepository('TFELibrairieBundle:Livre')->find($id);

        if ($livre == null) {
            throw $this->createNotFoundException("Le livre ".$id." n'existe pas.");
        }

        $session = $request->getSession();
        $ligneCommandes = $livre->getLivreCommandes();
        if (count($ligneCommandes))
        {
            $session->getFlashBag()->add('info', 'Suppression impossible. Ce livre est utilisé dans une ou plusieurs lignes de commande.');
            return $this->redirect($this->generateUrl('admin_livre_liste'));
        }

        $livre->supprimerPhoto();
        $em->remove($livre);
        $em->flush();

        $session->getFlashBag()->add('info', 'Livre supprimé.');
        return $this->redirect($this->generateUrl('admin_livre_liste'));
    }

    public function completeFormatAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $motcle = $request->query->get('motcle');

            $em = $this->getDoctrine()->getManager();
            $donnee = $em
                ->getRepository('TFELibrairieBundle:Format')
                ->autocomplete($motcle);

            return new JsonResponse($donnee);
        }
    }

    public function aCommanderAction()
    {
        $livresACommander = $this->getDoctrine()->getManager()->getRepository('TFELibrairieBundle:Livre')->listeCommande();

        return $this->render('@TFELibrairie/admin/livre/listeACommander.html.twig', array(
                'liste' => $livresACommander
            ));
    }

    public function majStockAction(Entity\Livre $id, Request $request)
    {
        $id->setStock( $id->getStock() + $request->request->get('quantiteCommandee') );
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('admin_livre_commander');
    }

} 