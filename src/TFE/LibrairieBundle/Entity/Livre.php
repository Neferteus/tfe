<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Livre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TFE\LibrairieBundle\Entity\LivreRepository")
 *
 * @UniqueEntity(
 *      fields = "codeIsbn",
 *      message = "Ce code isbn existe déjà."
 * )
 */
class Livre
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->accompagnements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->auteurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->livreCommandes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @var integer
     *
     * @ORM\Column(name="codeIsbn", type="string", length=20, unique=true)
     *
     * @Assert\NotBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "20",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     * @Assert\Isbn(
     *      isbn10 = true,
     *      isbn13 = true,
     *      bothIsbnMessage = "Entrez une valeur ISBN-10 ou 13."
     * )
     */
    private $codeIsbn;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=150)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\Length(
     *      max = "150",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="soustitre", type="string", length=150, nullable=true)
     *
     * @Assert\Length(
     *      max = "150",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $soustitre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="anneeParution", type="date")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\DateTime(message = "Veuillez encoder une date correcte.")
     */
    private $anneeParution;

    /**
     * @var string
     *
     * @ORM\Column(name="urlLivre", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $urlLivre;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Max. {{ limit }} caractères"
     * )
     */
    private $photo;

    /**
     * @Assert\Image(
     *      maxSize = "2000000",
     *      maxSizeMessage = "Votre fichier ne peut dépasser 2Mo.",
     *      mimeTypes = {"image/jpeg", "image/png", "image/gif"},
     *      mimeTypesMessage = "Format de fichier non supporté."
     * )
     */
    private $file;

    /**
     * @var boolean
     *
     * @ORM\Column(name="teteAffiche", type="boolean")
     *
     * @Assert\Type(
     *      type = "bool",
     *      message = "Type non valide."
     * )
     */
    private $teteAffiche;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aVenir", type="boolean")
     *
     * @Assert\Type(
     *      type = "bool",
     *      message = "Type non valide."
     * )
     */
    private $aVenir;

    /**
     * @var float
     *
     * @ORM\Column(name="prixVenteHtva", type="float")
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
    private $prixVenteHtva;

    /**
     * @var float
     *
     * @ORM\Column(name="tvaLivre", type="float")
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
    private $tvaLivre;

    /**
     * @var float
     *
     * @ORM\Column(name="ristourne", type="float")
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
    private $ristourne;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrVente", type="integer")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\GreaterThanOrEqual(
     *      value = 0,
     *      message = "Entrez un nombre > ou = à {{ compared_value }}."
     * )
     */
    private $nbrVente;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\GreaterThanOrEqual(
     *      value = 0,
     *      message = "Entrez un nombre > ou = à {{ compared_value }}."
     * )
     */
    private $stock;

    /**
     * @var integer
     *
     * @ORM\Column(name="seuilAlerte", type="integer")
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     * @Assert\GreaterThanOrEqual(
     *      value = 0,
     *      message = "Entrez un nombre > ou = à {{ compared_value }}."
     * )
     */
    private $seuilAlerte;

    /**
     * @var Accompagnement
     *
     * @ORM\ManyToMany(targetEntity="TFE\LibrairieBundle\Entity\Accompagnement", inversedBy="livres", cascade={"persist"})
     *
     */
    private $accompagnements;

    /**
     * @var Commentaire
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Commentaire", mappedBy="livre", cascade={"remove"})
     *
     */
    private $commentaires;

    /**
     * @var Note
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\Note", mappedBy="livre", cascade={"remove"})
     *
     */
    private $notes;

    /**
     * @var Auteur
     *
     * @ORM\ManyToMany(targetEntity="TFE\LibrairieBundle\Entity\Auteur", inversedBy="livres")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     */
    private $auteurs;

    /**
     * @var Categorie
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Categorie", inversedBy="livres")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     */
    private $categorie;

    /**
     * @var Format
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Format", inversedBy="livres")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     */
    private $format;

    /**
     * @var Collection
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Collection", inversedBy="livres")
     *
     */
    private $collection;

    /**
     * @var Edition
     *
     * @ORM\ManyToOne(targetEntity="TFE\LibrairieBundle\Entity\Edition", inversedBy="livres")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\notBlank(message = "Veuillez remplir ce champ")
     */
    private $edition;

    /**
     * @var LivreCommande
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\LivreCommande", mappedBy="livre")
     *
     */
    private $livreCommandes;

    /**
     * @var LivreNoteCredit
     *
     * @ORM\OneToMany(targetEntity="TFE\LibrairieBundle\Entity\LivreNoteCredit", mappedBy="livre")
     *
     */
    private $livreNoteCredits;





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
     * Set codeIsbn
     *
     * @param integer $codeIsbn
     * @return Livre
     */
    public function setCodeIsbn($codeIsbn)
    {
        $this->codeIsbn = $codeIsbn;

        return $this;
    }

    /**
     * Get codeIsbn
     *
     * @return integer 
     */
    public function getCodeIsbn()
    {
        return $this->codeIsbn;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Livre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set soustitre
     *
     * @param string $soustitre
     * @return Livre
     */
    public function setSoustitre($soustitre)
    {
        $this->soustitre = $soustitre;

        return $this;
    }

    /**
     * Get soustitre
     *
     * @return string 
     */
    public function getSoustitre()
    {
        return $this->soustitre;
    }

    /**
     * Set anneeParution
     *
     * @param \DateTime $anneeParution
     * @return Livre
     */
    public function setAnneeParution($anneeParution)
    {
        $this->anneeParution = $anneeParution;

        return $this;
    }

    /**
     * Get anneeParution
     *
     * @return \DateTime 
     */
    public function getAnneeParution()
    {
        return $this->anneeParution;
    }

    /**
     * Set urlLivre
     *
     * @param string $urlLivre
     * @return Livre
     */
    public function setUrlLivre($urlLivre)
    {
        $this->urlLivre = $urlLivre;

        return $this;
    }

    /**
     * Get urlLivre
     *
     * @return string 
     */
    public function getUrlLivre()
    {
        return $this->urlLivre;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Livre
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set teteAffiche
     *
     * @param boolean $teteAffiche
     * @return Livre
     */
    public function setTeteAffiche($teteAffiche)
    {
        $this->teteAffiche = $teteAffiche;

        return $this;
    }

    /**
     * Get teteAffiche
     *
     * @return boolean 
     */
    public function getTeteAffiche()
    {
        return $this->teteAffiche;
    }

    /**
     * Set aVenir
     *
     * @param boolean $aVenir
     * @return Livre
     */
    public function setAVenir($aVenir)
    {
        $this->aVenir = $aVenir;

        return $this;
    }

    /**
     * Get aVenir
     *
     * @return boolean 
     */
    public function getAVenir()
    {
        return $this->aVenir;
    }

    /**
     * Set prixVenteHtva
     *
     * @param float $prixVenteHtva
     * @return Livre
     */
    public function setPrixVenteHtva($prixVenteHtva)
    {
        $this->prixVenteHtva = $prixVenteHtva;

        return $this;
    }

    /**
     * Get prixVenteHtva
     *
     * @return float 
     */
    public function getPrixVenteHtva()
    {
        return $this->prixVenteHtva;
    }

    /**
     * Set tvaLivre
     *
     * @param float $tvaLivre
     * @return Livre
     */
    public function setTvaLivre($tvaLivre)
    {
        $this->tvaLivre = $tvaLivre;

        return $this;
    }

    /**
     * Get tvaLivre
     *
     * @return float 
     */
    public function getTvaLivre()
    {
        return $this->tvaLivre;
    }

    /**
     * Set ristourne
     *
     * @param float $ristourne
     * @return Livre
     */
    public function setRistourne($ristourne)
    {
        $this->ristourne = $ristourne;

        return $this;
    }

    /**
     * Get ristourne
     *
     * @return float 
     */
    public function getRistourne()
    {
        return $this->ristourne;
    }

    /**
     * Set nbrVente
     *
     * @param integer $nbrVente
     * @return Livre
     */
    public function setNbrVente($nbrVente)
    {
        $this->nbrVente = $nbrVente;

        return $this;
    }

    /**
     * Get nbrVente
     *
     * @return integer 
     */
    public function getNbrVente()
    {
        return $this->nbrVente;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return Livre
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set seuilAlerte
     *
     * @param integer $seuilAlerte
     * @return Livre
     */
    public function setSeuilAlerte($seuilAlerte)
    {
        $this->seuilAlerte = $seuilAlerte;

        return $this;
    }

    /**
     * Get seuilAlerte
     *
     * @return integer 
     */
    public function getSeuilAlerte()
    {
        return $this->seuilAlerte;
    }

    /**
     * Add accompagnements
     *
     * @param \TFE\LibrairieBundle\Entity\Accompagnement $accompagnements
     * @return Livre
     */
    public function addAccompagnement(\TFE\LibrairieBundle\Entity\Accompagnement $accompagnements)
    {
        $this->accompagnements[] = $accompagnements;

        return $this;
    }

    /**
     * Remove accompagnements
     *
     * @param \TFE\LibrairieBundle\Entity\Accompagnement $accompagnements
     */
    public function removeAccompagnement(\TFE\LibrairieBundle\Entity\Accompagnement $accompagnements)
    {
        $this->accompagnements->removeElement($accompagnements);
    }

    /**
     * Get accompagnements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAccompagnements()
    {
        return $this->accompagnements;
    }

    /**
     * Add commentaires
     *
     * @param \TFE\LibrairieBundle\Entity\Commentaire $commentaires
     * @return Livre
     */
    public function addCommentaire(\TFE\LibrairieBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires[] = $commentaires;

        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \TFE\LibrairieBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\TFE\LibrairieBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Add notes
     *
     * @param \TFE\LibrairieBundle\Entity\Note $notes
     * @return Livre
     */
    public function addNote(\TFE\LibrairieBundle\Entity\Note $notes)
    {
        $this->notes[] = $notes;

        return $this;
    }

    /**
     * Remove notes
     *
     * @param \TFE\LibrairieBundle\Entity\Note $notes
     */
    public function removeNote(\TFE\LibrairieBundle\Entity\Note $notes)
    {
        $this->notes->removeElement($notes);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add auteurs
     *
     * @param \TFE\LibrairieBundle\Entity\Auteur $auteurs
     * @return Livre
     */
    public function addAuteur(\TFE\LibrairieBundle\Entity\Auteur $auteurs)
    {
        $this->auteurs[] = $auteurs;

        return $this;
    }

    /**
     * Remove auteurs
     *
     * @param \TFE\LibrairieBundle\Entity\Auteur $auteurs
     */
    public function removeAuteur(\TFE\LibrairieBundle\Entity\Auteur $auteurs)
    {
        $this->auteurs->removeElement($auteurs);
    }

    /**
     * Get auteurs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuteurs()
    {
        return $this->auteurs;
    }

    /**
     * Set categorie
     *
     * @param \TFE\LibrairieBundle\Entity\Categorie $categorie
     * @return Livre
     */
    public function setCategorie(\TFE\LibrairieBundle\Entity\Categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \TFE\LibrairieBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set format
     *
     * @param \TFE\LibrairieBundle\Entity\Format $format
     * @return Livre
     */
    public function setFormat(\TFE\LibrairieBundle\Entity\Format $format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return \TFE\LibrairieBundle\Entity\Format 
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set colletion
     *
     * @param \TFE\LibrairieBundle\Entity\Collection $colletion
     * @return Livre
     */
    public function setCollection(\TFE\LibrairieBundle\Entity\Collection $collection = null)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get colletion
     *
     * @return \TFE\LibrairieBundle\Entity\Collection 
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Set edition
     *
     * @param \TFE\LibrairieBundle\Entity\Edition $edition
     * @return Livre
     */
    public function setEdition(\TFE\LibrairieBundle\Entity\Edition $edition)
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * Get edition
     *
     * @return \TFE\LibrairieBundle\Entity\Edition 
     */
    public function getEdition()
    {
        return $this->edition;
    }

    /**
     * Add livreCommandes
     *
     * @param \TFE\LibrairieBundle\Entity\LivreCommande $livreCommandes
     * @return Livre
     */
    public function addLivreCommande(\TFE\LibrairieBundle\Entity\LivreCommande $livreCommandes)
    {
        $this->livreCommandes[] = $livreCommandes;

        return $this;
    }

    /**
     * Remove livreCommandes
     *
     * @param \TFE\LibrairieBundle\Entity\LivreCommande $livreCommandes
     */
    public function removeLivreCommande(\TFE\LibrairieBundle\Entity\LivreCommande $livreCommandes)
    {
        $this->livreCommandes->removeElement($livreCommandes);
    }

    /**
     * Get livreCommandes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLivreCommandes()
    {
        return $this->livreCommandes;
    }

    /**
     * Add livreNoteCredits
     *
     * @param \TFE\LibrairieBundle\Entity\LivreNoteCredit $livreNoteCredits
     * @return Livre
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

    public function getPrixLivreHtvaAvecRistourne()
    {
        return round(
            ($this->getPrixVenteHtva() * (1 - ($this->getRistourne() / 100))),
            2
        );
    }
    public function getMontantTvaLivre()
    {
        return round($this->getPrixLivreHtvaAvecRistourne() * ($this->getTvaLivre() / 100), 2);
    }

    public function getPrixAccompagnementHtvaSansRistourne()
    {
        $prix = 0.0;

        $accompagnements = $this->getAccompagnements();
        foreach ($accompagnements as $accompagnement)
        {
            $prix += $accompagnement->getPrixHtvaAcc();
        }

        return $prix;
    }

    public function getPrixAccompagnementHtvaAvecRistourne()
    {
        return round( $this->getPrixAccompagnementHtvaSansRistourne() * ( 1 - ($this->getRistourne() / 100) ), 2);
    }

    public function getMontantTvaAccompagnement()
    {
        $montantTva = 0.0;

        $accompagnements = $this->getAccompagnements();
        foreach ($accompagnements as $accompagnement)
        {
            $montantTva += round( round(( $accompagnement->getPrixHtvaAcc() * ( 1 - ($this->getRistourne() / 100) ) ), 2) * round (( $accompagnement->getTvaAcc() / 100 ), 2), 2);
        }

        return $montantTva;
    }

    public function getPrixTotalHtva()
    {
        return $this->getPrixLivreHtvaAvecRistourne() + $this->getPrixAccompagnementHtvaAvecRistourne();
    }

    public function getTvaTotal()
    {
        return $this->getMontantTvaLivre() + $this->getMontantTvaAccompagnement();
    }

    public function getPrixTotal()
    {
        return $this->getPrixTotalHtva() + $this->getTvaTotal();

    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    public function upload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (null === $this->file) {
            return;
        }

        // On récupère le nom original du fichier de l'internaute
        $name = $this->getCodeIsbn() . '.' . $this->file->guessExtension();

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move($this->getUploadRootDir(), $name);

        // On sauvegarde le nom de fichier dans notre attribut $url
        $this->photo = $name;

        // On crée également le futur attribut alt de notre balise <img>
        //$this->alt = $name;
    }

    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
        return 'uploads/img';
    }

    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->getPhoto();
    }

    public function  getCachePhoto()
    {
        return __DIR__.'/../../../../web/media/cache/my_thumb/uploads/img/';
    }

    public function videCachePhoto()
    {
        if (file_exists($this->getCachePhoto() . $this->getPhoto()) )
        {
            unlink($this->getCachePhoto() . $this->getPhoto());
        }
    }

    public function supprimerPhoto()
    {
        if ($this->getPhoto() != null)
        {
            unlink($this->getWebPath());
            $this->videCachePhoto();
        }
    }

    public function getMoyenneNote()
    {
        $total = 0;
        $nbrNote = count($this->getNotes());

        if (!$nbrNote)
        {
            return 0;
        }

        foreach($this->getNotes() as $note)
        {
            $total += $note->getEtoile();
        }

        return round($total/$nbrNote);
    }
}
