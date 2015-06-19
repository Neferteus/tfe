<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Format
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\FormatRepository")
 *
 * @UniqueEntity(
 *      fields = "nomFormat",
 *      message = "Ce format est déjà enregistré."
 * )
 */
class Format
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->livres = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="nomFormat", type="string", length=30, unique=true)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "30",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nomFormat;

    /**
     * @var Livre
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Livre", mappedBy="format")
     *
     * @Assert\Valid
     */
    private $livres;

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
     * Set nomFormat
     *
     * @param string $nomFormat
     * @return Format
     */
    public function setNomFormat($nomFormat)
    {
        $this->nomFormat = $nomFormat;

        return $this;
    }

    /**
     * Get nomFormat
     *
     * @return string 
     */
    public function getNomFormat()
    {
        return $this->nomFormat;
    }

    /**
     * Add livres
     *
     * @param \TFE\LibrairieBundle\Entity\Livre $livres
     * @return Format
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
}
