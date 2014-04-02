<?php

namespace eni\QCMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Promotion
 *
 * @ORM\Table(name="promotions")
 * @ORM\Entity(repositoryClass="eni\QCMBundle\Entity\PromotionRepository")
 * @UniqueEntity(fields={"codePromo"})
 */
class Promotion
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="code_promo", type="string", length=8)
     */
    private $codePromo;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=64)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="Utilisateur", mappedBy="promotion");
     */
    private $stagiaires;

    function __construct()
    {
        $this->stagiaires = new ArrayCollection();
    }

    /**
     * Set codePromo
     *
     * @param string $codePromo
     * @return Promotion
     */
    public function setCodePromo($codePromo)
    {
        $this->codePromo = $codePromo;

        return $this;
    }

    /**
     * Get codePromo
     *
     * @return string 
     */
    public function getCodePromo()
    {
        return $this->codePromo;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Promotion
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
     * Set Stagiaires
     *
     * @param Utilisateur $stagiaires
     */
    public function setStagiaires($stagiaires)
    {
        $this->stagiaires = $stagiaires;
    }

    /**
     * Get Stagiaires
     *
     * @return Utilisateur
     */
    public function getStagiaires()
    {
        return $this->stagiaires;
    }

    function __toString()
    {
        return $this->getCodePromo();
    }


}
