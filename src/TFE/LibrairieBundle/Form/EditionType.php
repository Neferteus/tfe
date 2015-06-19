<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomEdition',     'text')
            ->add('urlEdition',     'text', array(
                    'required'  => false,
                ))
            ->add('sauvegarder',    'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TFE\LibrairieBundle\Entity\Edition'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_edition';
    }
}
