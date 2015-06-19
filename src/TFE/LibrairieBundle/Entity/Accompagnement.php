<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Accompagnement
 *
 * @ORM\Table(name="accompagnement")
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\AccompagnementRepository")
 *
 * @UniqueEntity(fields="nomAcc", message="Ce nom est déjà pris !")
 */
class Accompagnement
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
     * @ORM\Column(name="nomAcc", type="string", length=50, unique=true)
     *
     * @Assert\NotBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "50",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $nomAcc;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionAcc", type="text", nullable=true)
     */
    private $descriptionAcc;

    /**
     * @var float
     *
     * @ORM\Column(name="prixHtvaAcc", type="float")
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
    private $prixHtvaAcc;

    /**
     * @var float
     *
     * @ORM\Column(name="tvaAcc", type="float")
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
    private $tvaAcc;

    /**
     * @var Livre
     *
     * @ORM\ManyToMany(targetEntity="TFE\LibrairieBundle\Entity\Livre", mappedBy="accompagnements")
     *
     * @Assert\Valid
     */
    private $livres;

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
     * Set nomAcc
     *
     * @param string $nomAcc
     * @return Accompagnement
     */
    public function setNomAcc($nomAcc)
    {
        $this->nomAcc = $nomAcc;

        return $this;
    }

    /**
     * Get nomAcc
     *
     * @return string 
     */
    public function getNomAcc()
    {
        return $this->nomAcc;
    }

    /**
     * Set descriptionAcc
     *
     * @param string $descriptionAcc
     * @return Accompagnement
     */
    public function setDescriptionAcc($descriptionAcc)
    {
        $this->descriptionAcc = $descriptionAcc;

        return $this;
    }

    /**
     * Get descriptionAcc
     *
     * @return string 
     */
    public function getDescriptionAcc()
    {
        return $this->descriptionAcc;
    }

    /**
     * Set prixHtvaAcc
     *
     * @param float $prixHtvaAcc
     * @return Accompagnement
     */
    public function setPrixHtvaAcc($prixHtvaAcc)
    {
        $this->prixHtvaAcc = $prixHtvaAcc;

        return $this;
    }

    /**
     * Get prixHtvaAcc
     *
     * @return float 
     */
    public function getPrixHtvaAcc()
    {
        return $this->prixHtvaAcc;
    }

    /**
     * Set tvaAcc
     *
     * @param float $tvaAcc
     * @return Accompagnement
     */
    public function setTvaAcc($tvaAcc)
    {
        $this->tvaAcc = $tvaAcc;

        return $this;
    }

    /**
     * Get tvaAcc
     *
     * @return float 
     */
    public function getTvaAcc()
    {
        return $this->tvaAcc;
    }

    /**
     * Add livres
     *
     * @param \TFE\LibrairieBundle\Entity\Livre $livres
     * @return Accompagnement
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
     * @return float
     */
    public function getPrixTTC()
    {
        return round( $this->prixHtvaAcc * (1 + ($this->tvaAcc / 100)), 2);
    }

}
