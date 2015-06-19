<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Adresse
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\AdresseRepository")
 */
class Adresse
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
     * @ORM\Column(name="rue", type="string", length=150)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "50",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $rue;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=10)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "10",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $numero;

    /**
     * @var Ville
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Ville", inversedBy="adresses", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid
     */
    private $ville;

    /**
     * @var Utilisateur
     *
     * @ORM\OneToMany(targetEntity="TFE\UserBundle\Entity\Utilisateur", mappedBy="adresse")
     *
     * @Assert\Valid
     */
    private $utilisateurs;

    /**
     * @var Commande
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Commande", mappedBy="adresse")
     *
     * @Assert\Valid
     */
    private $commandes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set rue
     *
     * @param string $rue
     * @return Adresse
     */
    public function setRue($rue)
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get rue
     *
     * @return string 
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Adresse
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set ville
     *
     * @param \TFE\LibrairieBundle\Entity\Ville $ville
     * @return Adresse
     */
    public function setVille(\TFE\LibrairieBundle\Entity\Ville $ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \TFE\LibrairieBundle\Entity\Ville 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Add utilisateurs
     *
     * @param \TFE\UserBundle\Entity\Utilisateur $utilisateurs
     * @return Adresse
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

    /**
     * Add commandes
     *
     * @param \TFE\LibrairieBundle\Entity\Commande $commandes
     * @return Adresse
     */
    public function addCommande(\TFE\LibrairieBundle\Entity\Commande $commandes)
    {
        $this->commandes[] = $commandes;

        return $this;
    }

    /**
     * Remove commandes
     *
     * @param \TFE\LibrairieBundle\Entity\Commande $commandes
     */
    public function removeCommande(\TFE\LibrairieBundle\Entity\Commande $commandes)
    {
        $this->commandes->removeElement($commandes);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommandes()
    {
        return $this->commandes;
    }
}
