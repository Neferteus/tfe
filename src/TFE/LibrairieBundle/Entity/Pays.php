<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Pays
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\PaysRepository")
 *
 * @UniqueEntity(
 *      fields = "nomPays",
 *      message = "Pays existant."
 * )
 */
class Pays
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->villes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="nomPays", type="string", length=40, unique=true)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "40",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nomPays;

    /**
     * @var Ville
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Ville", mappedBy="pays")
     *
     * @Assert\Valid
     */
    private $villes;

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
     * Set nomPays
     *
     * @param string $nomPays
     * @return Pays
     */
    public function setNomPays($nomPays)
    {
        $this->nomPays = $nomPays;

        return $this;
    }

    /**
     * Get nomPays
     *
     * @return string 
     */
    public function getNomPays()
    {
        return $this->nomPays;
    }

    /**
     * Add villes
     *
     * @param \TFE\LibrairieBundle\Entity\Ville $villes
     * @return Pays
     */
    public function addVille(\TFE\LibrairieBundle\Entity\Ville $villes)
    {
        $this->villes[] = $villes;

        return $this;
    }

    /**
     * Remove villes
     *
     * @param \TFE\LibrairieBundle\Entity\Ville $villes
     */
    public function removeVille(\TFE\LibrairieBundle\Entity\Ville $villes)
    {
        $this->villes->removeElement($villes);
    }

    /**
     * Get villes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVilles()
    {
        return $this->villes;
    }
}
