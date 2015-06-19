<?php

namespace TFE\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use TFE\LibrairieBundle\Form\AdresseType;

class UtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',           'text')
            ->add('password',           'repeated', array(
                'type'  => 'password',
                'invalid_message'   => 'Les mots de passe doivent correspondre',
                'options'           => array('required' => true),
                'first_options'     => array('label'    => 'Mot de passe'),
                'second_options'    => array('label'    => 'Mot de passe(confirmation)'),
            ))
            ->add('salt',               'text', array('required'    =>  false))
            ->add('roles', 'choice',
                array(
                    'choices' => array(
                        'ROLE_USER'     => 'ROLE_USER',
                        'ROLE_AUTEUR'   => 'ROLE_AUTEUR',
                        'ROLE_VENDEUR'  => 'ROLE_VENDEUR',
                        'ROLE_ADMIN'    => 'ROLE_ADMIN'
                    ),
                'required'  => true,
                'multiple'  => true,
                'expanded'  => true
            ))
            ->add('nom',                'text')
            ->add('prenom',             'text')
            ->add('telephone',          'text')
            ->add('email',              'email')
            ->add('dateNaissance',      'birthday')
            ->add('adresse',            new AdresseType())
            ->add('sexe',               'entity',   array(
                'class'     =>  'TFELibrairieBundle:Sexe',
                'property'  =>  'genre',
                'multiple'      => false,
                'empty_value'   => 'Choisissez votre sexe',
            ))
            ->add('sauvegarder',        'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TFE\UserBundle\Entity\Utilisateur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_userbundle_utilisateur';
    }
}
