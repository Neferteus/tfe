<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Recompense
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\RecompenseRepository")
 *
 * @UniqueEntity(
 *      fields = "nomRecompense",
 *      message = "Récompense existante."
 * )
 */
class Recompense
{
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @ORM\Column(name="nomRecompense", type="string", length=60, unique=true)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "60",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nomRecompense;

    /**
     * @var AuteurRecompense
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\AuteurRecompense", mappedBy="recompense")
     *
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
     * Set nomRecompense
     *
     * @param string $nomRecompense
     * @return Recompense
     */
    public function setNomRecompense($nomRecompense)
    {
        $this->nomRecompense = $nomRecompense;

        return $this;
    }

    /**
     * Get nomRecompense
     *
     * @return string 
     */
    public function getNomRecompense()
    {
        return $this->nomRecompense;
    }

    /**
     * Add auteurRecompenses
     *
     * @param \TFE\LibrairieBundle\Entity\AuteurRecompense $auteurRecompenses
     * @return Recompense
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
}
