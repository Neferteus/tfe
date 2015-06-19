<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LivreModifierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {}
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_livre_modifier';
    }

    /**
     * @return LivreType
     */
    public function getParent()
    {
        return new LivreType();
    }


}
