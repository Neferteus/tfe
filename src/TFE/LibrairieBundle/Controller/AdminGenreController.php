<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 31-03-15
 * Time: 12:33
 */

namespace TFE\LibrairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TFE\LibrairieBundle\Entity as Entity;
use TFE\LibrairieBundle\Form as Form;

class AdminGenreController extends Controller
{
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $genres = $em->getRepository('TFELibrairieBundle:Genre')->getListe();

        return $this->render('TFELibrairieBundle:admin\genre:liste.html.twig', array(
            'genres'  => $genres
        ));
    }

    public function ajouterAction(Request $request)
    {
        $genre = new Entity\Genre();
        $form = $this->createForm(new Form\GenreAjoutType(), $genre);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($genre);
                $em->flush();

                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Genre ajouté');
                return $this->redirect($this->generateUrl('admin_genre_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin\genre:ajout.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    public function modifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $genre = $em->getRepository('TFELibrairieBundle:Genre')->find($id);

        if ($genre === null) {
            throw $this->createNotFoundException("Le genre ".$id." n'existe pas.");
        }

        $form = $this->createForm(new Form\GenreModifierType(), $genre);

        if ($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em->flush();
                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Genre modifié');
                return $this->redirect($this->generateUrl('admin_genre_liste'));
            }
        }

        return $this->render('TFELibrairieBundle:admin\genre:modifier.html.twig', array(
            'form'  => $form->createView(),
            'genre' => $genre
        ));
    }

    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $genre = $em->getRepository('TFELibrairieBundle:Genre')->find($id);

        if ($genre === null) {
            throw $this->createNotFoundException("Le genre ".$id." n'existe pas.");
        }

        $session = $request->getSession();
        $categories = $genre->getCategories();
        foreach ($categories as $categorie)
        {
            $livres = $categorie->getLivres();
            if (count($livres))
            {
                $session->getFlashBag()->add('info', 'Suppression impossible. Genre utilisé par un ou plusieurs livres');
                return $this->redirect($this->generateUrl('admin_genre_liste'));
            }
        }

        $em->remove($genre);
        $em->flush();
        $session->getFlashBag()->add('info', 'Genre supprimé');
        return $this->redirect($this->generateUrl('admin_genre_liste'));
    }
} 