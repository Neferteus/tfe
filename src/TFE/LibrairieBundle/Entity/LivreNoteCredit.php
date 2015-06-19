<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LivreNoteCredit
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\LivreNoteCreditRepository")
 */
class LivreNoteCredit
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
     * @ORM\Column(name="prixHtvaNc", type="float")
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
    private $prixHtvaNc;

    /**
     * @var float
     *
     * @ORM\Column(name="tvaNc", type="float")
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
    private $tvaNc;

    /**
     * @var Livre
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Livre", inversedBy="livreNoteCredits")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Valid
     */
    private $livre;

    /**
     * @var NoteCredit
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\NoteCredit", inversedBy="livreNoteCredits")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Valid
     */
    private $noteCredit;


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
     * @return LivreNoteCredit
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
     * Set prixHtvaNc
     *
     * @param float $prixHtvaNc
     * @return LivreNoteCredit
     */
    public function setPrixHtvaNc($prixHtvaNc)
    {
        $this->prixHtvaNc = $prixHtvaNc;

        return $this;
    }

    /**
     * Get prixHtvaNc
     *
     * @return float 
     */
    public function getPrixHtvaNc()
    {
        return $this->prixHtvaNc;
    }

    /**
     * Set tvaNc
     *
     * @param float $tvaNc
     * @return LivreNoteCredit
     */
    public function setTvaNc($tvaNc)
    {
        $this->tvaNc = $tvaNc;

        return $this;
    }

    /**
     * Get tvaNc
     *
     * @return float 
     */
    public function getTvaNc()
    {
        return $this->tvaNc;
    }

    /**
     * Set livre
     *
     * @param \TFE\LibrairieBundle\Entity\Livre $livre
     * @return LivreNoteCredit
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
     * Set noteCredit
     *
     * @param \TFE\LibrairieBundle\Entity\NoteCredit $noteCredit
     * @return LivreNoteCredit
     */
    public function setNoteCredit(\TFE\LibrairieBundle\Entity\NoteCredit $noteCredit)
    {
        $this->noteCredit = $noteCredit;

        return $this;
    }

    /**
     * Get noteCredit
     *
     * @return \TFE\LibrairieBundle\Entity\NoteCredit 
     */
    public function getNoteCredit()
    {
        return $this->noteCredit;
    }
}
