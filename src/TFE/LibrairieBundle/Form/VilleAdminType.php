<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VilleAdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codePostal', 'text')
            ->add('localite',   'text')
            ->add('pays',       'entity',   array(
                'class'     =>  'TFELibrairieBundle:Pays',
                'property'  =>  'nomPays',
                'required'  =>  false
            ))
        ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_ville_admin';
    }

    /**
     * @return VilleType
     */
    public function getParent()
    {
        return new VilleType();
    }


}
