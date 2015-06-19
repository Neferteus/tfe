<?php

namespace TFE\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use TFE\LibrairieBundle\Form\AdresseAdminType;

class UtilisateurVoirType extends AbstractType
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
            ->remove('sauvegarder')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_userbundle_utilisateur_voir';
    }

    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface|UtilisateurType
     */
    public function getParent()
    {
        return new UtilisateurType();
    }
}
