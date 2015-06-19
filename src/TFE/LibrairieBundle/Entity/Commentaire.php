<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commentaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="texteCommentaire", type="text")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     */
    private $texteCommentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCommentaire", type="datetime")
     *
     * @Assert\DateTime(message = "Veuillez encoder une date correcte.")
     */
    private $dateCommentaire;

    /**
     * @var boolean
     *
     * @ORM\Column(name="blocageCom", type="boolean")
     *
     * @Assert\Type(
     *      type = "bool",
     *      message = "Type non valide."
     * )
     */
    private $blocageCom;

    /**
     * @var Livre
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Livre", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $livre;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="TFE\UserBundle\Entity\Utilisateur", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)

     */
    private $utilisateur;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set texteCommentaire
     *
     * @param string $texteCommentaire
     * @return Commentaire
     */
    public function setTexteCommentaire($texteCommentaire)
    {
        $this->texteCommentaire = $texteCommentaire;

        return $this;
    }

    /**
     * Get texteCommentaire
     *
     * @return string 
     */
    public function getTexteCommentaire()
    {
        return $this->texteCommentaire;
    }

    /**
     * Set dateCommentaire
     *
     * @param \DateTime $dateCommentaire
     * @return Commentaire
     */
    public function setDateCommentaire($dateCommentaire)
    {
        $this->dateCommentaire = $dateCommentaire;

        return $this;
    }

    /**
     * Get dateCommentaire
     *
     * @return \DateTime 
     */
    public function getDateCommentaire()
    {
        return $this->dateCommentaire;
    }

    /**
     * Set blocageCom
     *
     * @param boolean $blocageCom
     * @return Commentaire
     */
    public function setBlocageCom($blocageCom)
    {
        $this->blocageCom = $blocageCom;

        return $this;
    }

    /**
     * Get blocageCom
     *
     * @return boolean 
     */
    public function getBlocageCom()
    {
        return $this->blocageCom;
    }

    /**
     * Set livre
     *
     * @param \TFE\LibrairieBundle\Entity\Livre $livre
     * @return Commentaire
     */
    public function setLivre(\TFE\LibrairieBundle\Entity\Livre $livre)
    {
        $this->livre = $livre;

        return $this;
    }

    /**
     * Get livre
     *
     * @return \TFE\LibrairieBundle\Entity\Livre 
     */
    public function getLivre()
    {
        return $this->livre;
    }

    /**
     * Set utilisateur
     *
     * @param \TFE\UserBundle\Entity\Utilisateur $utilisateur
     * @return Commentaire
     */
    public function setUtilisateur(\TFE\UserBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \TFE\UserBundle\Entity\Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
