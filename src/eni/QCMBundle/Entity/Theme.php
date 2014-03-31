<?php

namespace eni\QCMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Theme
 *
 * @ORM\Table(name="themes")
 * @ORM\Entity(repositoryClass="eni\QCMBundle\Entity\ThemeRepository")
 */
class Theme
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
     * @ORM\Column(name="libelle", type="string", length=64)
     */
    private $libelle;

    /**
     * @var ArrayCollection(Section)
     *
     * @ORM\OneToMany(targetEntity="Section", mappedBy="theme")
     */
    private $sections;

    /**
     * @var ArrayCollection(Question)
     *
     * @ORM\ManyToMany(targetEntity="Question", mappedBy="themes")
     */
    private $questions;

    function __construct()
    {
        $this->sections = new ArrayCollection();
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
     * Set libelle
     *
     * @param string $libelle
     * @return Theme
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
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
     * @param \Doctrine\Common\Collections\ArrayCollection $sections
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSections()
    {
        return $this->sections;
    }

    function __toString()
    {
        return $this->getLibelle();
    }


}
