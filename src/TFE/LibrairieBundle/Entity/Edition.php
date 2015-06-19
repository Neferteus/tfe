<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Edition
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\EditionRepository")
 *
 * @UniqueEntity(fields="nomEdition", message="Cette maison d'édition est déjà enregistrée !")
 */
class Edition
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
     * @ORM\Column(name="nomEdition", type="string", length=30, unique=true)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "30",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nomEdition;

    /**
     * @var string
     *
     * @ORM\Column(name="urlEdition", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $urlEdition;

    /**
     * @var Livre
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Livre", mappedBy="edition")
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
     * Set nomEdition
     *
     * @param string $nomEdition
     * @return Edition
     */
    public function setNomEdition($nomEdition)
    {
        $this->nomEdition = $nomEdition;

        return $this;
    }

    /**
     * Get nomEdition
     *
     * @return string 
     */
    public function getNomEdition()
    {
        return $this->nomEdition;
    }

    /**
     * Set urlEdition
     *
     * @param string $urlEdition
     * @return Edition
     */
    public function setUrlEdition($urlEdition)
    {
        $this->urlEdition = $urlEdition;

        return $this;
    }

    /**
     * Get urlEdition
     *
     * @return string 
     */
    public function getUrlEdition()
    {
        return $this->urlEdition;
    }

    /**
     * Add livres
     *
     * @param \TFE\LibrairieBundle\Entity\Livre $livres
     * @return Edition
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
