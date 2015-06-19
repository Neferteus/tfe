<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ModeLivraison
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\ModeLivraisonRepository")
 *
 * @UniqueEntity(
 *      fields = "nomModeLivraison",
 *      message = "Mode de livraison existant."
 * )
 */
class ModeLivraison
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
     * @ORM\Column(name="nomModeLivraison", type="string", length=30, unique=true)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "30",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nomModeLivraison;

    /**
     * @var float
     *
     * @ORM\Column(name="prixModeLivraisonHtva", type="float")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\GreaterThanOrEqual(
     *      value = 0,
     *      message = "Entrez un nombre > ou = à {{ compared_value }}."
     * )
     * @Assert\Type(
     *      type = "float",
     *      message = "Type non valide."
     * )
     */
    private $prixModeLivraisonHtva;

    /**
     * @var float
     *
     * @ORM\Column(name="tvaModeLivraison", type="float")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\GreaterThanOrEqual(
     *      value = 0,
     *      message = "Entrez un nombre > ou = à {{ compared_value }}."
     * )
     * @Assert\Type(
     *      type = "float",
     *      message = "Type non valide."
     * )
     */
    private $tvaModeLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="urlSuiviModeLivraison", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $urlSuiviModeLivraison;

    /**
     * @var Commande
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Commande", mappedBy="modeLivraison")
     *
     * @Assert\Valid
     */
    private $commandes;

    function __toString()
    {
        return $this->nomModeLivraison . "  -  " . $this->prixModeLivraisonHtva . " €";
    }

    public function getMontantTva()
    {
        return round($this->getPrixModeLivraisonHtva() * ($this->getTvaModeLivraison()/100) ,2);
    }

    public function getPrixTTC()
    {
        return $this->getPrixModeLivraisonHtva() + $this->getMontantTva();
    }




    // ********** GETTER ET SETTER **********

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
     * Set nomModeLivraison
     *
     * @param string $nomModeLivraison
     * @return ModeLivraison
     */
    public function setNomModeLivraison($nomModeLivraison)
    {
        $this->nomModeLivraison = $nomModeLivraison;

        return $this;
    }

    /**
     * Get nomModeLivraison
     *
     * @return string 
     */
    public function getNomModeLivraison()
    {
        return $this->nomModeLivraison;
    }

    /**
     * Set prixModeLivraisonHtva
     *
     * @param float $prixModeLivraisonHtva
     * @return ModeLivraison
     */
    public function setPrixModeLivraisonHtva($prixModeLivraisonHtva)
    {
        $this->prixModeLivraisonHtva = $prixModeLivraisonHtva;

        return $this;
    }

    /**
     * Get prixModeLivraisonHtva
     *
     * @return float 
     */
    public function getPrixModeLivraisonHtva()
    {
        return $this->prixModeLivraisonHtva;
    }

    /**
     * Set tvaModeLivraison
     *
     * @param float $tvaModeLivraison
     * @return ModeLivraison
     */
    public function setTvaModeLivraison($tvaModeLivraison)
    {
        $this->tvaModeLivraison = $tvaModeLivraison;

        return $this;
    }

    /**
     * Get tvaModeLivraison
     *
     * @return float 
     */
    public function getTvaModeLivraison()
    {
        return $this->tvaModeLivraison;
    }

    /**
     * Set urlSuiviModeLivraison
     *
     * @param string $urlSuiviModeLivraison
     * @return ModeLivraison
     */
    public function setUrlSuiviModeLivraison($urlSuiviModeLivraison)
    {
        $this->urlSuiviModeLivraison = $urlSuiviModeLivraison;

        return $this;
    }

    /**
     * Get urlSuiviModeLivraison
     *
     * @return string 
     */
    public function getUrlSuiviModeLivraison()
    {
        return $this->urlSuiviModeLivraison;
    }

    /**
     * Add commandes
     *
     * @param \TFE\LibrairieBundle\Entity\Commande $commandes
     * @return ModeLivraison
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
