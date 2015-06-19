<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategorieModifierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('genre');
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_categorie_modifier';
    }

    public function getParent()
    {
        return new CategorieType();
    }


}
