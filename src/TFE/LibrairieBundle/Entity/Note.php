<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Note
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "TFE\LibrairieBundle\Entity\NoteRepository")
 *
 */
class Note
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
     * @var integer
     *
     * @ORM\Column(name="etoile", type="integer")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Ce chiffre doit être compris entre 1 et 5.",
     *      maxMessage = "Ce chiffre doit être compris entre 1 et 5.",
     *      invalidMessage = "Type non valide."
     * )
     */
    private $etoile;

    /**
     * @var boolean
     *
     * @ORM\Column(name="blocage", type="boolean")
     *
     * @Assert\Type(
     *      type = "bool",
     *      message = "Type non valide."
     * )
     */
    private $blocage;

    /**
     * @var Livre
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Livre", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $livre;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="TFE\UserBundle\Entity\Utilisateur", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     *
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
     * Set etoile
     *
     * @param integer $etoile
     * @return Note
     */
    public function setEtoile($etoile)
    {
        $this->etoile = $etoile;

        return $this;
    }

    /**
     * Get etoile
     *
     * @return integer 
     */
    public function getEtoile()
    {
        return $this->etoile;
    }

    /**
     * Set blocage
     *
     * @param boolean $blocage
     * @return Note
     */
    public function setBlocage($blocage)
    {
        $this->blocage = $blocage;

        return $this;
    }

    /**
     * Get blocage
     *
     * @return boolean 
     */
    public function getBlocage()
    {
        return $this->blocage;
    }

    /**
     * Set livre
     *
     * @param \TFE\LibrairieBundle\Entity\Livre $livre
     * @return Note
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
     * @return Note
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
