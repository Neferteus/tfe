<?php

namespace TFE\LibrairieBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use TFE\LibrairieBundle\Form\DataTransformer\FormatToStringTransformer;

class LivreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['em'];
        $transformer = new FormatToStringTransformer($entityManager);

        $builder
            ->add('codeIsbn',       'text')
            ->add('titre',          'text')
            ->add('soustitre',      'text', array(
                    'required' => false
                ))
            ->add('anneeParution',  'birthday', array(
                    'empty_value' => '',
                ))
            ->add('teteAffiche',    'checkbox', array(
                    'required' => false
                ))
            ->add('aVenir',         'checkbox', array(
                    'required' => false
                ))
            ->add('prixVenteHtva',  'number')
            ->add('tvaLivre',       'number')
            ->add('ristourne',      'number')
            ->add('nbrVente',       'number')
            ->add('stock',          'number')
            ->add('seuilAlerte',    'number')
            ->add('accompagnements',    'entity',
                array(
                    'class'         => 'TFELibrairieBundle:Accompagnement',
                    'property'      => 'nomAcc',
                    'multiple'      => true,
                    'empty_value'   => 'Choisissez un accompagnement',
                    'required'      => false
                ))
            ->add('auteurs',            'collection',
                array(
                    'type'      => 'entity',
                    'prototype' => true,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'options'   => array (
                        'class'         => 'TFELibrairieBundle:Auteur',
                        'query_builder' => function(EntityRepository $er) {
                          return $er->createQueryBuilder('a')
                              ->orderBy('a.nomAuteur', 'ASC');
                        },
                        'multiple'      => false,
                        'empty_value'   => 'Choisissez un auteur'
                    ),

                ))
            ->add('categorie',          'entity',
                array(
                    'class'         => 'TFELibrairieBundle:Categorie',
                    'empty_value'   => 'Choisissez une categorie',
                ))
            ->add(
                $builder->create('format', 'text')
                    ->addModelTransformer($transformer)
            )
            ->add('collection',    'entity',
                array(
                    'class'     => 'TFELibrairieBundle:Collection',
                    'property'  => 'nomCollection',
                    'empty_value' => 'Choisissez une collection',
                    'required'  => false
                ))
            ->add('edition',    'entity',
                array(
                    'class'     => 'TFELibrairieBundle:Edition',
                    'empty_value' => "Choisissez une maison d'édition",
                    'property'  => 'nomEdition'
                ))
            ->add('file')
            ->add('sauvegarder',    'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TFE\LibrairieBundle\Entity\Livre'
        ));

        $resolver->setRequired(array(
                'em',
            ));

        $resolver->setAllowedTypes(array(
                'em' => 'Doctrine\Common\Persistence\ObjectManager',
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_livre';
    }
}
