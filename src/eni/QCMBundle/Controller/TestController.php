<?php

namespace eni\QCMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\Common\Collections\ArrayCollection;
use eni\QCMBundle\Entity\Test;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     *
     * @Route("/", name="admin_menu")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('eniQCMBundle:Admin:index.html.twig', array('name' => ""));
    }
}