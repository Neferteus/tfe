<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CollectionModifierType extends AbstractType
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
        return 'tfe_librairiebundle_collection_modifier';
    }

    /**
     * @return CollectionType
     */
    public function getParent()
    {
        return new CollectionType();
    }
}
