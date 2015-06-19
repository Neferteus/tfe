<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdresseAdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rue',    'text')
            ->add('numero', 'text')
            ->add('ville',  new VilleAdminType(), array('required' => false))
        ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_adresse_admin';
    }

    /**
     * @return AdresseType
     */
    public function getParent()
    {
        return new AdresseType();
    }


}
