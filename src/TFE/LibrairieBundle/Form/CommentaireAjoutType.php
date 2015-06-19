<?php

namespace TFE\LibrairieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentaireAjoutType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('dateCommentaire')
            ->remove('blocageCom')
            ->remove('livre')
            ->remove('utilisateur')
        ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'tfe_librairiebundle_commentaire_ajout';
    }

    /**
     * @return CommentaireType
     */
    public function getParent()
    {
        return new CommentaireType();
    }


}
