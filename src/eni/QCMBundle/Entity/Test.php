<?php

namespace eni\QCMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Test
 *
 * @ORM\Table(name="tests")
 * @ORM\Entity(repositoryClass="eni\QCMBundle\Entity\TestRepository")
 *
 * @UniqueEntity(fields={"nom"})
 */
class Test
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", unique=true, length=64)
     *
     * @Assert\Length(min= "2", max = "64")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Assert\Length(min= "0", max = "4096")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duree", type="time")
     *
     * @Assert\Time()
     */
    private $duree;

    /**
     * @var integer
     *
     * @ORM\Column(name="seuil", type="smallint")
     *
     * @Assert\Range(min= "0", max = "100")
     */
    private $seuil;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur");
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")
     *
     * @Assert\NotNull()
     */
    private $formateur;

    /**
     * @ORM\OneToMany(targetEntity="Section", mappedBy="test", cascade={"all"});
     */
    private $sections;

    function __construct()
    {
        $this->sections = new ArrayCollection();
    }


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
     * @return Test
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
     * Set description
     *
     * @param string $description
     * @return Test
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set duree
     *
     * @param \DateTime $duree
     * @return Test
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return \DateTime 
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set seuil
     *
     * @param integer $seuil
     * @return Test
     */
    public function setSeuil($seuil)
    {
        $this->seuil = $seuil;

        return $this;
    }

    /**
     * Get seuil
     *
     * @return integer 
     */
    public function getSeuil()
    {
        return $this->seuil;
    }

    /**
     * Set formateur
     *
     * @param Utilisateur $formateur
     */
    public function setFormateur($formateur)
    {
        $this->formateur = $formateur;
    }

    /**
     * Get formateur
     *
     * @return Utilisateur
     */
    public function getFormateur()
    {
        return $this->formateur;
    }

    /**
     * @return ArrayCollection
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param Section $section
     */
    public function addSection(Section $section)
    {
        if (!$this->sections->contains($section)) {
            $section->setTest($this);
            $this->sections->add($section);
        }
    }

    /**
     * @param Section $section
     */
    public function removeSection(Section $section)
    {
        if ($this->sections->contains($section)) {
            $this->sections->removeElement($section);
        }
    }


}
