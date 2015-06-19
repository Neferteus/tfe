<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AuteurModifierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options){}
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_auteur_modifier';
    }

    public function getParent()
    {
        return new AuteurType();
    }


}
