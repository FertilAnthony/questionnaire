<?php

namespace eni\QCMBundle\Controller;

use FOS\UserBundle\Doctrine\UserManager;
use eni\QCMBundle\Entity\Utilisateur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;


class DefaultController extends Controller
{

	/**
	 * @var Utilisateur
	 */
	private $oUtilisateurConnecte = NULL;

	public function preExecute() {
		$oSecurityContext = $this->get('security.context');
		/* @var $oSecurityContext SecurityContext */
		if ($oSecurityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			$this->oUtilisateurConnecte = $oSecurityContext->getToken()->getUser();
		}
	}

	/**
	 * @Route("/", name="accueil", options={"expose"=true})
	 * @Template()
	 */
    public function indexAction(Request $oRequest) {

    	var_dump($this->oUtilisateurConnecte);

        return $this->render('eniQCMBundle:Default:index.html.twig');
    }
}
