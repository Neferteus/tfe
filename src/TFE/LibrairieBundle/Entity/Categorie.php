<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Categorie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\CategorieRepository")
 *
 * @UniqueEntity(
 *      fields = {"nomCategorie", "genre"},
 *      message = "Combinaison déjà encodée."
 * )
 */
class Categorie
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
     * @ORM\Column(name="nomCategorie", type="string", length=30)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "30",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nomCategorie;

    /**
     * @var Livre
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Livre", mappedBy="categorie")
     *
     * @Assert\Valid
     */
    private $livres;

    /**
     * @var Genre
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Genre", inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Valid
     */
    private $genre;


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
     * Set nomCategorie
     *
     * @param string $nomCategorie
     * @return Categorie
     */
    public function setNomCategorie($nomCategorie)
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * Get nomCategorie
     *
     * @return string 
     */
    public function getNomCategorie()
    {
        return $this->nomCategorie;
    }

    /**
     * Add livres
     *
     * @param \TFE\LibrairieBundle\Entity\Livre $livres
     * @return Categorie
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
     * Set genre
     *
     * @param \TFE\LibrairieBundle\Entity\Genre $genre
     * @return Categorie
     */
    public function setGenre(\TFE\LibrairieBundle\Entity\Genre $genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return \TFE\LibrairieBundle\Entity\Genre 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    function __toString()
    {
        return $this->nomCategorie . ' - ' . $this->getGenre()->getNomGenre();
    }


}
