<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * News
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\NewsRepository")
 *
 * @UniqueEntity(
 *      fields = "titreNews",
 *      message = "Ce titre existe déjà"
 * )
 */
class News
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
     * @ORM\Column(name="titreNews", type="string", length=100, unique=true)
     *
     * @Assert\NotBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "100",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $titreNews;

    /**
     * @var string
     *
     * @ORM\Column(name="texteNews", type="text")
     *
     * @Assert\NotBlank(message = "Veuillez remplir ce champ")
     */
    private $texteNews;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNews", type="datetime")
     * @Assert\DateTime(message = "Veuillez encoder une date correcte.")
     */
    private $dateNews;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valide", type="boolean")
     *
     * @Assert\Type(
     *      type = "bool",
     *      message = "Type non valide."
     * )
     */
    private $valide;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accueil", type="boolean")
     *
     * @Assert\Type(
     *      type = "bool",
     *      message = "Type non valide."
     * )
     */
    private $accueil;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="TFE\UserBundle\Entity\Utilisateur", inversedBy="news")
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
     * Set titreNews
     *
     * @param string $titreNews
     * @return News
     */
    public function setTitreNews($titreNews)
    {
        $this->titreNews = $titreNews;

        return $this;
    }

    /**
     * Get titreNews
     *
     * @return string 
     */
    public function getTitreNews()
    {
        return $this->titreNews;
    }

    /**
     * Set texteNews
     *
     * @param string $texteNews
     * @return News
     */
    public function setTexteNews($texteNews)
    {
        $this->texteNews = $texteNews;

        return $this;
    }

    /**
     * Get texteNews
     *
     * @return string 
     */
    public function getTexteNews()
    {
        return $this->texteNews;
    }

    /**
     * Set dateNews
     *
     * @param \DateTime $dateNews
     * @return News
     */
    public function setDateNews($dateNews)
    {
        $this->dateNews = $dateNews;

        return $this;
    }

    /**
     * Get dateNews
     *
     * @return \DateTime 
     */
    public function getDateNews()
    {
        return $this->dateNews;
    }

    /**
     * Set valide
     *
     * @param boolean $valide
     * @return News
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide
     *
     * @return boolean 
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * Set accueil
     *
     * @param boolean $accueil
     * @return News
     */
    public function setAccueil($accueil)
    {
        $this->accueil = $accueil;

        return $this;
    }

    /**
     * Get accueil
     *
     * @return boolean 
     */
    public function getAccueil()
    {
        return $this->accueil;
    }

    /**
     * Set utilisateur
     *
     * @param \TFE\UserBundle\Entity\Utilisateur $utilisateur
     * @return News
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
