<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Collection
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\CollectionRepository")
 *
 * @UniqueEntity(fields="nomCollection", message="Cette collection est déjà enregistrée.")
 */
class Collection
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
     * @ORM\Column(name="nomCollection", type="string", length=30, unique=true)
     *
     * @Assert\NotBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "30",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nomCollection;

    /**
     * @var Livre
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Livre", mappedBy="collection")
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
     * Set nomCollection
     *
     * @param string $nomCollection
     * @return Collection
     */
    public function setNomCollection($nomCollection)
    {
        $this->nomCollection = $nomCollection;

        return $this;
    }

    /**
     * Get nomCollection
     *
     * @return string 
     */
    public function getNomCollection()
    {
        return $this->nomCollection;
    }

    /**
     * Add livres
     *
     * @param \TFE\LibrairieBundle\Entity\Livre $livres
     * @return Collection
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
