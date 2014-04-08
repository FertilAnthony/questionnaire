<?php

namespace eni\QCMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionTirage
 *
 * @ORM\Table(name="questions_tirage")
 * @ORM\Entity(repositoryClass="eni\QCMBundle\Entity\QuestionTirageRepository")
 */
class QuestionTirage
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
     * @var boolean
     *
     * @ORM\Column(name="estMarquee", type="boolean")
     */
    private $estMarquee;

    /**
     * @var Question
     *
     * @ORM\ManyToOne(targetEntity="Question", cascade={"all"}, inversedBy="questionTirages")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;

    /**
     * @var ArrayCollection;
     *
     * @ORM\ManyToMany(targetEntity="Reponse")
     * @ORM\JoinTable(name="reponse_donnee",
     *      joinColumns={@ORM\JoinColumn(name="question_tirage_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="reponse_proposee_id", referencedColumnName="id")}
     *      )
     */
    private $reponses;

    /**
     * @var Inscription
     *
     * @ORM\ManyToOne(targetEntity="Inscription", inversedBy="questions")
     * @ORM\JoinColumn(name="inscription_id", referencedColumnName="id")
     */
    private $inscription;

    function __construct()
    {
        $this->reponses = new ArrayCollection();
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
     * Set estMarquee
     *
     * @param boolean $estMarquee
     * @return Question_tirage
     */
    public function setEstMarquee($estMarquee)
    {
        $this->estMarquee = $estMarquee;

        return $this;
    }

    /**
     * Get estMarquee
     *
     * @return boolean 
     */
    public function getEstMarquee()
    {
        return $this->estMarquee;
    }

    /**
     * Set question
     *
     * @param \eni\QCMBundle\Entity\Question $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * Get question
     *
     * @return \eni\QCMBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param \eni\QCMBundle\Entity\Inscription $inscription
     */
    public function setInscription($inscription)
    {
        $this->inscription = $inscription;
    }

    /**
     * @return \eni\QCMBundle\Entity\Inscription
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * Set reponses stagiaire
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $reponses
     */
    public function setReponses($reponses)
    {
        $this->reponses = $reponses;
    }

    /**
     * Get reponses stagiaire
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getReponses()
    {
        return $this->reponses;
    }




}
