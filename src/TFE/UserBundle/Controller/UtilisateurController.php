<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 30-03-15
 * Time: 09:50
 */

namespace TFE\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TFE\UserBundle\Form as Form;
use TFE\UserBundle\Entity as Entity;

class UtilisateurController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function inscriptionAction(Request $request)
    {
        $utilisateur = new Entity\Utilisateur();

        $form = $this->createForm(new Form\UtilisateurAjoutType(), $utilisateur);

        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);

            // On crée un sel pour le cryptage du mot de passe
            $utilisateur->setSalt( hash('sha1', (new \DateTime())->format('d-m-Y H:i:s')) );

            // Crypter le mot de passe via la méthode définie dans security.yml.
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($utilisateur);
            $password = $encoder->encodePassword($form->get('password')->getData(), $utilisateur->getSalt());
            $utilisateur->setPassword($password);

            // Création du code activation pour la validation par email
            $utilisateur->setCodeActivation(hash('md5',($utilisateur->getUsername() . (new \DateTime())->format('d-m-Y H:i:s')) ));

            // Sauvegarde
            $em->flush();

            // On crée la page html qu'on va intégrer dans notre email
            $corpsEmail = $this->renderView('TFELibrairieBundle:utilitaire:email.html.twig', array(
                'utilisateur'   => $utilisateur
            ));

            // Envoi de l'email
            $message = \Swift_Message::newInstance()
                ->setSubject("Confirmation d'inscription")
                ->setFrom('bacinfogestion@gmail.com')
                ->setTo($utilisateur->getEmail())
                ->setBody($corpsEmail, 'text/html')
            ;
            $this->get('mailer')->send($message);

            // On retourne la page de confirmation de la crétion du compte
            return $this->render('TFELibrairieBundle:accueil:envoiMail.html.twig');
        }

        return $this->render('TFEUserBundle:utilisateur:inscription.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function confirmationAction(Request $request)
    {
        if ($request->isMethod('GET'))
        {
            $username = $request->query->get('user');
            $codeActivation = $request->query->get('code');

            $em = $this->getDoctrine()->getManager();

            $utilisateur = $em->getRepository('TFEUserBundle:Utilisateur')->confirmEmail($username, $codeActivation);

            if ($utilisateur !== null)
            {
                $utilisateur->setInscriptionValide(true);
                $utilisateur->setCodeActivation("");
                $em->persist($utilisateur);
                $em->flush();

                return $this->render('TFELibrairieBundle:accueil:confirmEmail.html.twig');
            }

            return $this->render('TFELibrairieBundle:accueil:invalideEmail.html.twig');
        }

        return $this->render('TFELibrairieBundle:accueil:invalideEmail.html.twig');
    }
} 