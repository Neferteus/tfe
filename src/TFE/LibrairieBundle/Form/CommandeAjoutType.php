<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CommandeAjoutType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('nrCommande')
            ->remove('dateCommande')
            ->remove('enAttente')
            ->remove('envoye')
            ->remove('annule')
            ->remove('facture')
            ->remove('utilisateur')
        ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_commande_ajout';
    }

    public function getParent()
    {
        return new CommandeType();
    }


}
