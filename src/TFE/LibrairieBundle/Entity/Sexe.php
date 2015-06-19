<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Sexe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\SexeRepository")
 *
 * @UniqueEntity(
 *      fields = "genre",
 *      message = "Déjà sauvegardé."
 * )
 */
class Sexe
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
     * @ORM\Column(name="genre", type="string", length=20, unique=true)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "20",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $genre;

    /**
     * @var Utilisateur
     *
     * @ORM\OneToMany(targetEntity="TFE\UserBundle\Entity\Utilisateur", mappedBy="sexe")
     *
     * @Assert\Valid
     */
    private $utilisateurs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set genre
     *
     * @param string $genre
     * @return Sexe
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Add utilisateurs
     *
     * @param \TFE\UserBundle\Entity\Utilisateur $utilisateurs
     * @return Sexe
     */
    public function addUtilisateur(\TFE\UserBundle\Entity\Utilisateur $utilisateurs)
    {
        $this->utilisateurs[] = $utilisateurs;

        return $this;
    }

    /**
     * Remove utilisateurs
     *
     * @param \TFE\UserBundle\Entity\Utilisateur $utilisateurs
     */
    public function removeUtilisateur(\TFE\UserBundle\Entity\Utilisateur $utilisateurs)
    {
        $this->utilisateurs->removeElement($utilisateurs);
    }

    /**
     * Get utilisateurs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }
}
