<?php

namespace eni\QCMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('eniQCMBundle:Default:index.html.twig', array('name' => $name));
    }
}
