<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ModePaiement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\ModePaiementRepository")
 *
 * @UniqueEntity(
 *      fields = "nomPaiement",
 *      message = "Nom de paiement existant."
 * )
 */
class ModePaiement
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="nomPaiement", type="string", length=30, unique=true)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "30",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nomPaiement;

    /**
     * @var integer
     *
     * @ORM\Column(name="dureeHeure", type="integer", nullable=true)
     *
     * @Assert\GreaterThanOrEqual(
     *      value = 0,
     *      message = "Entrez un nombre > ou = à {{ compared_value }}."
     * )
     * @Assert\Type(
     *      type = "int",
     *      message = "Type non valide."
     * )
     */
    private $dureeHeure;

    /**
     * @var Commande
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Commande", mappedBy="modePaiement")
     *
     * @Assert\Valid
     */
    private $commandes;

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
     * Set nomPaiement
     *
     * @param string $nomPaiement
     * @return ModePaiement
     */
    public function setNomPaiement($nomPaiement)
    {
        $this->nomPaiement = $nomPaiement;

        return $this;
    }

    /**
     * Get nomPaiement
     *
     * @return string 
     */
    public function getNomPaiement()
    {
        return $this->nomPaiement;
    }

    /**
     * Set dureeHeure
     *
     * @param integer $dureeHeure
     * @return ModePaiement
     */
    public function setDureeHeure($dureeHeure)
    {
        $this->dureeHeure = $dureeHeure;

        return $this;
    }

    /**
     * Get dureeHeure
     *
     * @return integer 
     */
    public function getDureeHeure()
    {
        return $this->dureeHeure;
    }

    /**
     * Add commandes
     *
     * @param \TFE\LibrairieBundle\Entity\Commande $commandes
     * @return ModePaiement
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
