<?php

namespace eni\QCMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use eni\QCMBundle\Entity\Reponse;

/**
 * Question
 *
 * @ORM\Table(name="questions")
 * @ORM\Entity(repositoryClass="eni\QCMBundle\Entity\QuestionRepository")
 */
class Question
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
     * @ORM\Column(name="enonce", type="text")
     */
    private $enonce;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=15)
     */
    private $type;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Theme", inversedBy="questions")
     * @ORM\JoinTable(name="question_theme",
     *      joinColumns={@ORM\JoinColumn(name="question_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="theme_id", referencedColumnName="id")}
     *      )
     */
    private $themes;

    /**
     * @ORM\OneToMany(targetEntity="Reponse", mappedBy="question", cascade={"all"})
     */
    private $reponses;

    function __construct()
    {
        /*$this->themes = new ArrayCollection();
        $this->reponses = new ArrayCollection();*/
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
     * Set enonce
     *
     * @param string $enonce
     * @return Question
     */
    public function setEnonce($enonce)
    {
        $this->enonce = $enonce;

        return $this;
    }

    /**
     * Get enonce
     *
     * @return string 
     */
    public function getEnonce()
    {
        return $this->enonce;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Question
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param ArrayCollection $themes
     */
    public function setThemes($themes)
    {
        $this->themes = $themes;
    }

    /**
     * @return ArrayCollection
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Get reponses proposées
     *
     * @return \eni\QCMBundle\Entity\ArrayCollection
     */
    public function getReponses()
    {
        return $this->reponses;
    }

    /**
     * @param Section $reponse
     */
    public function addReponse(Reponse $reponse)
    {
        if (!$this->reponses->contains($reponse)) {
            $reponse->setQuestion($this);
            $this->reponses->add($reponse);
        }
    }

    /**
     * @param Section $reponse
     */
    public function removeReponse(Reponse $reponse)
    {
        if ($this->reponses->contains($reponse)) {
            $this->reponses->removeElement($reponse);
        }
    }



}
