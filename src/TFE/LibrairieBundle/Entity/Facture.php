<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Facture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\FactureRepository")
 *
 */
class Facture
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->noteCredits = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="nrFacture", type="string", length=30, unique=true, nullable=true)
     *
     * @Assert\Length(
     *      max = "30",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nrFacture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFacture", type="datetime")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\DateTime(message = "Veuillez encoder une date correcte.")
     */
    private $dateFacture;

    /**
     * @var NoteCredit
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\NoteCredit", mappedBy="facture")
     *
     */
    private $noteCredits;

    /**
     * @var Commande
     *
     * @ORM\OneToOne(targetEntity="TFE\LibrairieBundle\Entity\Commande", mappedBy="facture")
     *
     */
    private $commande;

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
     * Set nrFacture
     *
     * @param string $nrFacture
     * @return Facture
     */
    public function setNrFacture($nrFacture)
    {
        $this->nrFacture = $nrFacture;

        return $this;
    }

    /**
     * Get nrFacture
     *
     * @return string 
     */
    public function getNrFacture()
    {
        return $this->nrFacture;
    }

    /**
     * Set dateFacture
     *
     * @param \DateTime $dateFacture
     * @return Facture
     */
    public function setDateFacture($dateFacture)
    {
        $this->dateFacture = $dateFacture;

        return $this;
    }

    /**
     * Get dateFacture
     *
     * @return \DateTime 
     */
    public function getDateFacture()
    {
        return $this->dateFacture;
    }

    /**
     * Add noteCredits
     *
     * @param \TFE\LibrairieBundle\Entity\NoteCredit $noteCredits
     * @return Facture
     */
    public function addNoteCredit(\TFE\LibrairieBundle\Entity\NoteCredit $noteCredits)
    {
        $this->noteCredits[] = $noteCredits;

        return $this;
    }

    /**
     * Remove noteCredits
     *
     * @param \TFE\LibrairieBundle\Entity\NoteCredit $noteCredits
     */
    public function removeNoteCredit(\TFE\LibrairieBundle\Entity\NoteCredit $noteCredits)
    {
        $this->noteCredits->removeElement($noteCredits);
    }

    /**
     * Get noteCredits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNoteCredits()
    {
        return $this->noteCredits;
    }

    /**
     * Set commande
     *
     * @param \TFE\LibrairieBundle\Entity\Commande $commande
     * @return Facture
     */
    public function setCommande(\TFE\LibrairieBundle\Entity\Commande $commande = null)
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
