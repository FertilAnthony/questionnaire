<?php

namespace eni\QCMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="sections")
 * @ORM\Entity(repositoryClass="eni\QCMBundle\Entity\SectionRepository")
 */
class Section
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
     * @var integer
     *
     * @ORM\Column(name="nbQuestion", type="integer")
     */
    private $nbQuestion;

    /**
     * @ORM\ManyToOne(targetEntity="Theme", inversedBy="sections")
     * @ORM\JoinColumn(name="theme_id", referencedColumnName="id")
     */
    private $theme;

    /**
     * @var ArrayCollection(Section)
     *
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="sections")
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     */
    private $test;


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
     * Set nbQuestion
     *
     * @param integer $nbQuestion
     * @return Section
     */
    public function setNbQuestion($nbQuestion)
    {
        $this->nbQuestion = $nbQuestion;

        return $this;
    }

    /**
     * Get nbQuestion
     *
     * @return integer 
     */
    public function getNbQuestion()
    {
        return $this->nbQuestion;
    }

    /**
     * @param \eni\QCMBundle\Entity\Theme $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return \eni\QCMBundle\Entity\Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param mixed $test
     */
    public function setTest($test)
    {
        $this->test = $test;
    }

    /**
     * @return mixed
     */
    public function getTest()
    {
        return $this->test;
    }

    function __toString()
    {
        return $this->getTheme()->getLibelle();
    }


}
