<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LivreAjoutCommandeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('prixVenteFinalHtva')
            ->remove('tvaVente')
            ->remove('livre')
            ->remove('commande')
        ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_livrecommande_ajout';
    }

    /**
     * @return LivreCommandeType
     */
    public function getParent()
    {
        return new LivreCommandeType();
    }


}
