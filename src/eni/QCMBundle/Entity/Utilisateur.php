<?php

namespace eni\QCMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="UtilisateurRepository")
 */
class Utilisateur extends User
{
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=100)
     */
    private $prenom;

   /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Promotion", inversedBy="stagiaires",cascade={"all"})
     * @ORM\JoinColumn(name="code_promo", referencedColumnName="code_promo", nullable=true)
     */
    private $promotion;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=64)
     *
     * @Assert\Choice(choices = {"formateur", "stagiaire"})
     */
    private $type;

    /**
    * @ORM\OneToMany(targetEntity="Inscription", mappedBy="utilisateur", cascade={"persist"})
    */
    private $inscriptions;

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
     * Set nom
     *
     * @param string $nom
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set Promotion
     * @param Promotion $promotion
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * Get Promotion
     * @return Promotion
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    // Vérifie si l'utilisateur est formateur
    public function estFormateur() {
        return in_array('formateur', $this->getType());
    }

    public function addInscription(Inscription $inscription) {
        $this->inscription[] = $inscription;
        return $this;
    }

    public function removeInscription(Inscription $inscription) {
        $this->inscriptions->removeElement($inscription);
    }

    public function getInscription() {
        return $this->inscriptions;
    }


    function __toString()
    {
        return strtoupper($this->getNom()) . ' ' . ucfirst($this->getPrenom());
    }
}
