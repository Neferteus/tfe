<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LivreCommande
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\LivreCommandeRepository")
 */
class LivreCommande
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
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\GreaterThanOrEqual(
     *      value = 0,
     *      message = "Entrez un nombre > ou = à {{ compared_value }}."
     * )
     * @Assert\Type(
     *      type = "int",
     *      message = "Type non valide."
     * )
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="prixVenteFinalHtva", type="float")
     *
     * @Assert\GreaterThanOrEqual(
     *      value = 0,
     *      message = "Entrez un nombre > ou = à {{ compared_value }}."
     * )
     * @Assert\Type(
     *      type = "float",
     *      message = "Type non valide."
     * )
     */
    private $prixVenteFinalHtva;

    /**
     * @var float
     *
     * @ORM\Column(name="tvaVente", type="float")
     *
     * @Assert\GreaterThanOrEqual(
     *      value = 0,
     *      message = "Entrez un nombre > ou = à {{ compared_value }}."
     * )
     * @Assert\Type(
     *      type = "float",
     *      message = "Type non valide."
     * )
     */
    private $tvaVente;

    /**
     * @var Livre
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Livre", inversedBy="livreCommandes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $livre;

    /**
     * @var Commande
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Commande", inversedBy="livreCommandes")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $commande;

    public function getTotalLigneCommandeTTC()
    {
        return $this->getPrixVenteFinalHtva() + $this->getTvaVente();
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
     * Set quantite
     *
     * @param integer $quantite
     * @return LivreCommande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prixVenteFinalHtva
     *
     * @param float $prixVenteFinalHtva
     * @return LivreCommande
     */
    public function setPrixVenteFinalHtva($prixVenteFinalHtva)
    {
        $this->prixVenteFinalHtva = $prixVenteFinalHtva;

        return $this;
    }

    /**
     * Get prixVenteFinalHtva
     *
     * @return float 
     */
    public function getPrixVenteFinalHtva()
    {
        return $this->prixVenteFinalHtva;
    }

    /**
     * Set tvaVente
     *
     * @param float $tvaVente
     * @return LivreCommande
     */
    public function setTvaVente($tvaVente)
    {
        $this->tvaVente = $tvaVente;

        return $this;
    }

    /**
     * Get tvaVente
     *
     * @return float 
     */
    public function getTvaVente()
    {
        return $this->tvaVente;
    }

    /**
     * Set livre
     *
     * @param \TFE\LibrairieBundle\Entity\Livre $livre
     * @return LivreCommande
     */
    public function setLivre(\TFE\LibrairieBundle\Entity\Livre $livre)
    {
        $this->livre = $livre;

        return $this;
    }

    /**
     * Get livre
     *
     * @return \TFE\LibrairieBundle\Entity\Livre 
     */
    public function getLivre()
    {
        return $this->livre;
    }

    /**
     * Set commande
     *
     * @param \TFE\LibrairieBundle\Entity\Commande $commande
     * @return LivreCommande
     */
    public function setCommande(\TFE\LibrairieBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \TFE\LibrairieBundle\Entity\Commande 
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
