<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * NoteCredit
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\NoteCreditRepository")
 *
 * @UniqueEntity(
 *      fields = "nrNoteCredit",
 *      message = "N° note de crédit existant."
 * )
 */
class NoteCredit
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->livreNoteCredits = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="nrNoteCredit", type="string", length=30, unique=true)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "30",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nrNoteCredit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNoteCredit", type="datetime")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\DateTime(message = "Veuillez encoder une date correcte.")
     */
    private $dateNoteCredit;

    /**
     * @var LivreNoteCredit
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\LivreNoteCredit", mappedBy="noteCredit")
     *
     * @Assert\Valid
     */
    private $livreNoteCredits;

    /**
     * @var Facture
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Facture", inversedBy="noteCredits")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Valid
     */
    private  $facture;

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
     * Set nrNoteCredit
     *
     * @param string $nrNoteCredit
     * @return NoteCredit
     */
    public function setNrNoteCredit($nrNoteCredit)
    {
        $this->nrNoteCredit = $nrNoteCredit;

        return $this;
    }

    /**
     * Get nrNoteCredit
     *
     * @return string 
     */
    public function getNrNoteCredit()
    {
        return $this->nrNoteCredit;
    }

    /**
     * Set dateNoteCredit
     *
     * @param \DateTime $dateNoteCredit
     * @return NoteCredit
     */
    public function setDateNoteCredit($dateNoteCredit)
    {
        $this->dateNoteCredit = $dateNoteCredit;

        return $this;
    }

    /**
     * Get dateNoteCredit
     *
     * @return \DateTime 
     */
    public function getDateNoteCredit()
    {
        return $this->dateNoteCredit;
    }

    /**
     * Add livreNoteCredits
     *
     * @param \TFE\LibrairieBundle\Entity\LivreNoteCredit $livreNoteCredits
     * @return NoteCredit
     */
    public function addLivreNoteCredit(\TFE\LibrairieBundle\Entity\LivreNoteCredit $livreNoteCredits)
    {
        $this->livreNoteCredits[] = $livreNoteCredits;

        return $this;
    }

    /**
     * Remove livreNoteCredits
     *
     * @param \TFE\LibrairieBundle\Entity\LivreNoteCredit $livreNoteCredits
     */
    public function removeLivreNoteCredit(\TFE\LibrairieBundle\Entity\LivreNoteCredit $livreNoteCredits)
    {
        $this->livreNoteCredits->removeElement($livreNoteCredits);
    }

    /**
     * Get livreNoteCredits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLivreNoteCredits()
    {
        return $this->livreNoteCredits;
    }

    /**
     * Set facture
     *
     * @param \TFE\LibrairieBundle\Entity\Facture $facture
     * @return NoteCredit
     */
    public function setFacture(\TFE\LibrairieBundle\Entity\Facture $facture)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \TFE\LibrairieBundle\Entity\Facture 
     */
    public function getFacture()
    {
        return $this->facture;
    }
}
