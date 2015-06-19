<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Genre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\GenreRepository")
 *
 * @UniqueEntity(
 *      fields = "nomGenre",
 *      message = "Ce genre est déjà enregistré."
 * )
 */
class Genre
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="nomGenre", type="string", length=30, unique=true)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "30",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nomGenre;

    /**
     * @var Categorie
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Categorie", mappedBy="genre", cascade={"remove"})
     *
     * @Assert\Valid
     */
    private $categories;

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
     * Set nomGenre
     *
     * @param string $nomGenre
     * @return Genre
     */
    public function setNomGenre($nomGenre)
    {
        $this->nomGenre = $nomGenre;

        return $this;
    }

    /**
     * Get nomGenre
     *
     * @return string 
     */
    public function getNomGenre()
    {
        return $this->nomGenre;
    }

    /**
     * Add categories
     *
     * @param \TFE\LibrairieBundle\Entity\Categorie $categories
     * @return Genre
     */
    public function addCategory(\TFE\LibrairieBundle\Entity\Categorie $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \TFE\LibrairieBundle\Entity\Categorie $categories
     */
    public function removeCategory(\TFE\LibrairieBundle\Entity\Categorie $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
