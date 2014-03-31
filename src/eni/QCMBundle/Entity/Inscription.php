<?php

namespace eni\QCMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Inscription
 *
 * @ORM\Table(name="inscriptions")
 * @ORM\Entity(repositoryClass="eni\QCMBundle\Entity\InscriptionRepository")
 */
class Inscription
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
     * @ORM\Column(name="dureeValidite", type="datetime")
     */
    private $dureeValidite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tempsEcoule", type="datetime")
     */
    private $tempsEcoule;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=20)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="resultat", type="integer")
     */
    private $resultat;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")
     */
    private $utilisateur;

    /**
     * @var Test
     *
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     */
    private $test;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="QuestionTirage", mappedBy="inscription")
     */
    private $questions;

    function __construct()
    {
        $this->questions = new ArrayCollection();
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
     * Set dureeValidite
     *
     * @param \DateTime $dureeValidite
     * @return Inscription
     */
    public function setDureeValidite($dureeValidite)
    {
        $this->dureeValidite = $dureeValidite;

        return $this;
    }

    /**
     * Get dureeValidite
     *
     * @return \DateTime 
     */
    public function getDureeValidite()
    {
        return $this->dureeValidite;
    }

    /**
     * Set tempsEcoule
     *
     * @param \DateTime $tempsEcoule
     * @return Inscription
     */
    public function setTempsEcoule($tempsEcoule)
    {
        $this->tempsEcoule = $tempsEcoule;

        return $this;
    }

    /**
     * Get tempsEcoule
     *
     * @return \DateTime 
     */
    public function getTempsEcoule()
    {
        return $this->tempsEcoule;
    }

    /**
     * Set etat
     *
     * @param string $etat
     * @return Inscription
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set resultat
     *
     * @param integer $resultat
     * @return Inscription
     */
    public function setResultat($resultat)
    {
        $this->resultat = $resultat;

        return $this;
    }

    /**
     * Get resultat
     *
     * @return integer 
     */
    public function getResultat()
    {
        return $this->resultat;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $questions
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param \eni\QCMBundle\Entity\Utilisateur $utilisateur
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;
    }

    /**
     * @return \eni\QCMBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * @param \eni\QCMBundle\Entity\Test $test
     */
    public function setTest($test)
    {
        $this->test = $test;
    }

    /**
     * @return \eni\QCMBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }


}
