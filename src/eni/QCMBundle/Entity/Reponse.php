<?php

namespace eni\QCMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponses")
 * @ORM\Entity(repositoryClass="eni\QCMBundle\Entity\ReponseRepository")
 */
class Reponse
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
     * @ORM\Column(name="libelle", type="text")
     */
    private $libelle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estBonne", type="boolean")
     */
    private $estBonne;

    /**
     * @var Question
     *
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="reponses", cascade={"all"})
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;


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
     * @return Reponse
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
     * Set estBonne
     *
     * @param boolean $estBonne
     * @return Reponse
     */
    public function setEstBonne($estBonne)
    {
        $this->estBonne = $estBonne;

        return $this;
    }

    /**
     * Get estBonne
     *
     * @return boolean 
     */
    public function getEstBonne()
    {
        return $this->estBonne;
    }

    /**
     * @param \eni\QCMBundle\Entity\Question $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return \eni\QCMBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }


}
