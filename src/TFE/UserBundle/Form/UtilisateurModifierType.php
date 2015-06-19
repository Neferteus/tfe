<?php

namespace TFE\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use TFE\LibrairieBundle\Form\AdresseAdminType;

class UtilisateurModifierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('salt')
            ->remove('password')
            ->remove('adresse')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_userbundle_utilisateur_modifier';
    }

    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface|UtilisateurType
     */
    public function getParent()
    {
        return new UtilisateurType();
    }
}
