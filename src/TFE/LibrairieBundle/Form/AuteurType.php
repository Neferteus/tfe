<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AuteurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomAuteur',              'text')
            ->add('prenomAuteur',           'text')
            ->add('telephoneAuteur',        'text',
                array('required'    => false))
            ->add('emailAuteur',            'text',
                array('required'    => false))
            ->add('dateNaissanceAuteur',    'date',
                array('required'    => false))
            ->add('dateDecesAuteur',        'date',
                array('required'    => false))
            ->add('sauvegarder',            'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TFE\LibrairieBundle\Entity\Auteur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_auteur';
    }
}
