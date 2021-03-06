<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommandeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nrCommande')
            ->add('dateCommande')
            ->add('enAttente')
            ->add('envoye')
            ->add('annule')
            ->add('facture')
            ->add('modeLivraison',  'entity', array(
                    'class'         =>  'TFELibrairieBundle:ModeLivraison',
                    'multiple'      => false,
                    'expanded'      => false
                ))
            ->add('modePaiement',   'entity', array(
                    'class'         =>  'TFELibrairieBundle:ModePaiement',
                    'property'      =>  'nomPaiement',
                    'multiple'      => false,
                    'expanded'      => false
                ))
            ->add('utilisateur')
            ->add('adresse',        new AdresseType())
            ->add('sauvegarder',    'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TFE\LibrairieBundle\Entity\Commande'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_commande';
    }
}
