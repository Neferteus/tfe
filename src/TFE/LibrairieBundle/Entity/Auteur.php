<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Auteur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\AuteurRepository")
 *
 * @UniqueEntity(
 *      fields = {"nomAuteur", "prenomAuteur"},
 *      message = "Cette association nom et prénom est déjà enregistrée")
 */
class Auteur
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->livres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->auteurRecompenses = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @ORM\Column(name="nomAuteur", type="string", length=50)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "50",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nomAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomAuteur", type="string", length=50)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "50",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $prenomAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="telephoneAuteur", type="string", length=25, nullable=true)
     *
     * @Assert\Length(
     *      max = "25",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $telephoneAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="emailAuteur", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $emailAuteur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissanceAuteur", type="date", nullable=true)
     *
     * @Assert\DateTime(message = "Veuillez encoder une date correcte.")
     */
    private $dateNaissanceAuteur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDecesAuteur", type="date", nullable=true)
     *
     * @Assert\DateTime(message = "Veuillez encoder une date correcte.")
     */
    private $dateDecesAuteur;

    /**
     * @var Livre
     *
     * @ORM\ManyToMany(targetEntity="TFE\LibrairieBundle\Entity\Livre", mappedBy="auteurs")
     *
     * @Assert\Valid
     */
    private $livres;

    /**
     * @var AuteurRecompense
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\AuteurRecompense", mappedBy="auteur")
     *
     * @Assert\Valid
     */
    private $auteurRecompenses;

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
     * Set nomAuteur
     *
     * @param string $nomAuteur
     * @return Auteur
     */
    public function setNomAuteur($nomAuteur)
    {
        $this->nomAuteur = $nomAuteur;

        return $this;
    }

    /**
     * Get nomAuteur
     *
     * @return string 
     */
    public function getNomAuteur()
    {
        return $this->nomAuteur;
    }

    /**
     * Set prenomAuteur
     *
     * @param string $prenomAuteur
     * @return Auteur
     */
    public function setPrenomAuteur($prenomAuteur)
    {
        $this->prenomAuteur = $prenomAuteur;

        return $this;
    }

    /**
     * Get prenomAuteur
     *
     * @return string 
     */
    public function getPrenomAuteur()
    {
        return $this->prenomAuteur;
    }

    /**
     * Set telephoneAuteur
     *
     * @param string $telephoneAuteur
     * @return Auteur
     */
    public function setTelephoneAuteur($telephoneAuteur)
    {
        $this->telephoneAuteur = $telephoneAuteur;

        return $this;
    }

    /**
     * Get telephoneAuteur
     *
     * @return string 
     */
    public function getTelephoneAuteur()
    {
        return $this->telephoneAuteur;
    }

    /**
     * Set emailAuteur
     *
     * @param string $emailAuteur
     * @return Auteur
     */
    public function setEmailAuteur($emailAuteur)
    {
        $this->emailAuteur = $emailAuteur;

        return $this;
    }

    /**
     * Get emailAuteur
     *
     * @return string 
     */
    public function getEmailAuteur()
    {
        return $this->emailAuteur;
    }

    /**
     * Set dateNaissanceAuteur
     *
     * @param \DateTime $dateNaissanceAuteur
     * @return Auteur
     */
    public function setDateNaissanceAuteur($dateNaissanceAuteur)
    {
        $this->dateNaissanceAuteur = $dateNaissanceAuteur;

        return $this;
    }

    /**
     * Get dateNaissanceAuteur
     *
     * @return \DateTime 
     */
    public function getDateNaissanceAuteur()
    {
        return $this->dateNaissanceAuteur;
    }

    /**
     * Set dateDecesAuteur
     *
     * @param \DateTime $dateDecesAuteur
     * @return Auteur
     */
    public function setDateDecesAuteur($dateDecesAuteur)
    {
        $this->dateDecesAuteur = $dateDecesAuteur;

        return $this;
    }

    /**
     * Get dateDecesAuteur
     *
     * @return \DateTime 
     */
    public function getDateDecesAuteur()
    {
        return $this->dateDecesAuteur;
    }

    /**
     * Add livres
     *
     * @param \TFE\LibrairieBundle\Entity\Livre $livres
     * @return Auteur
     */
    public function addLivre(\TFE\LibrairieBundle\Entity\Livre $livres)
    {
        $this->livres[] = $livres;

        return $this;
    }

    /**
     * Remove livres
     *
     * @param \TFE\LibrairieBundle\Entity\Livre $livres
     */
    public function removeLivre(\TFE\LibrairieBundle\Entity\Livre $livres)
    {
        $this->livres->removeElement($livres);
    }

    /**
     * Get livres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLivres()
    {
        return $this->livres;
    }

    /**
     * Add auteurRecompenses
     *
     * @param \TFE\LibrairieBundle\Entity\AuteurRecompense $auteurRecompenses
     * @return Auteur
     */
    public function addAuteurRecompense(\TFE\LibrairieBundle\Entity\AuteurRecompense $auteurRecompenses)
    {
        $this->auteurRecompenses[] = $auteurRecompenses;

        return $this;
    }

    /**
     * Remove auteurRecompenses
     *
     * @param \TFE\LibrairieBundle\Entity\AuteurRecompense $auteurRecompenses
     */
    public function removeAuteurRecompense(\TFE\LibrairieBundle\Entity\AuteurRecompense $auteurRecompenses)
    {
        $this->auteurRecompenses->removeElement($auteurRecompenses);
    }

    /**
     * Get auteurRecompenses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuteurRecompenses()
    {
        return $this->auteurRecompenses;
    }

    function __toString()
    {
        return $this->nomAuteur . ' ' . $this->prenomAuteur;
    }

}
