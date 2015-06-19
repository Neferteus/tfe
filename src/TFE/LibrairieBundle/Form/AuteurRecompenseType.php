<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AuteurRecompenseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anneeDistinction',   'birthday')
            ->add('auteur',             'entity',
                array(
                    'class'         => 'TFELibrairieBundle:Auteur',
                    'multiple'      => false,
                    'expanded'      => false,
                    'empty_value'   => 'Choisissez un auteur',
                    'required'      => true
                ))
            ->add('recompense',         'entity',
                array(
                    'class'         => 'TFELibrairieBundle:Recompense',
                    'property'      => 'nomRecompense',
                    'multiple'      => false,
                    'expanded'      => false,
                    'empty_value'   => 'Choisissez une récompense',
                    'required'      => true
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
            'data_class' => 'TFE\LibrairieBundle\Entity\AuteurRecompense'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_auteurrecompense';
    }
}
