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
	private $roles = NULL;

	public function preExecute() {
		$oSecurityContext = $this->get('security.context');
		/* @var $oSecurityContext SecurityContext */
		if ($oSecurityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			$this->oUtilisateurConnecte = $oSecurityContext->getToken()->getUser();
			$this->roles = $this->oUtilisateurConnecte->getRoles();
		}
	}

	/**
	 * @Route("/", name="accueil", options={"expose"=true})
	 * @Template()
	 */
    public function indexAction(Request $oRequest) {

    	
    	if (isset($this->roles) && in_array('ROLE_ADMIN', $this->roles)) {
    		var_dump($this->roles);
    		return $this->redirect($this->generateUrl('admin_menu'));
    	} else {
    		return $this->render('eniQCMBundle:Default:index.html.twig');
    	}
    }
}
