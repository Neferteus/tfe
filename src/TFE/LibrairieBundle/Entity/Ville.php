<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Ville
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\VilleRepository")
 */
class Ville
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->adresses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="codePostal", type="string", length=15)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "15",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $codePostal = null;

    /**
     * @var string
     *
     * @ORM\Column(name="localite", type="string", length=40)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "40",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $localite = null;

    /**
     * @var Pays
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Pays", inversedBy="villes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Valid
     */
    private  $pays;

    /**
     * @var Adresse
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Adresse", mappedBy="ville")
     *
     * @Assert\Valid
     */
    private $adresses;

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
     * Set codePostal
     *
     * @param string $codePostal
     * @return Ville
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set localite
     *
     * @param string $localite
     * @return Ville
     */
    public function setLocalite($localite)
    {
        $this->localite = $localite;

        return $this;
    }

    /**
     * Get localite
     *
     * @return string 
     */
    public function getLocalite()
    {
        return $this->localite;
    }

    /**
     * Set pays
     *
     * @param \TFE\LibrairieBundle\Entity\Pays $pays
     * @return Ville
     */
    public function setPays(\TFE\LibrairieBundle\Entity\Pays $pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \TFE\LibrairieBundle\Entity\Pays 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Add adresses
     *
     * @param \TFE\LibrairieBundle\Entity\Adresse $adresses
     * @return Ville
     */
    public function addAdress(\TFE\LibrairieBundle\Entity\Adresse $adresses)
    {
        $this->adresses[] = $adresses;

        return $this;
    }

    /**
     * Remove adresses
     *
     * @param \TFE\LibrairieBundle\Entity\Adresse $adresses
     */
    public function removeAdress(\TFE\LibrairieBundle\Entity\Adresse $adresses)
    {
        $this->adresses->removeElement($adresses);
    }

    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdresses()
    {
        return $this->adresses;
    }
}
