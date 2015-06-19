<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * AuteurRecompense
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\AuteurRecompenseRepository")
 *
 * @UniqueEntity(
 *      fields = {"anneeDistinction", "auteur", "recompense"},
 *      message = "Combinaison déjà encodée."
 * )
 */
class AuteurRecompense
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
     * @var \DateTime
     *
     * @ORM\Column(name="anneeDistinction", type="date")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\DateTime(message = "Veuillez encoder une date correcte.")
     */
    private $anneeDistinction;

    /**
     * @var Auteur
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Auteur", inversedBy="auteurRecompenses", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     */
    private $auteur;

    /**
     * @var Recompense
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Recompense", inversedBy="auteurRecompenses", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     */
    private $recompense;

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
     * Set anneeDistinction
     *
     * @param \DateTime $anneeDistinction
     * @return AuteurRecompense
     */
    public function setAnneeDistinction($anneeDistinction)
    {
        $this->anneeDistinction = $anneeDistinction;

        return $this;
    }

    /**
     * Get anneeDistinction
     *
     * @return \DateTime 
     */
    public function getAnneeDistinction()
    {
        return $this->anneeDistinction;
    }

    /**
     * Set auteur
     *
     * @param \TFE\LibrairieBundle\Entity\Auteur $auteur
     * @return AuteurRecompense
     */
    public function setAuteur(\TFE\LibrairieBundle\Entity\Auteur $auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \TFE\LibrairieBundle\Entity\Auteur 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set recompense
     *
     * @param \TFE\LibrairieBundle\Entity\Recompense $recompense
     * @return AuteurRecompense
     */
    public function setRecompense(\TFE\LibrairieBundle\Entity\Recompense $recompense)
    {
        $this->recompense = $recompense;

        return $this;
    }

    /**
     * Get recompense
     *
     * @return \TFE\LibrairieBundle\Entity\Recompense 
     */
    public function getRecompense()
    {
        return $this->recompense;
    }
}
