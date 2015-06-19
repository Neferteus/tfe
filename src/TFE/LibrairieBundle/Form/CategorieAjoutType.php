<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategorieAjoutType extends AbstractType
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
        return 'tfe_librairiebundle_categorie_ajout';
    }

    /**
     * @return CategorieType
     */
    public function getParent()
    {
        return new CategorieType();
    }


}
