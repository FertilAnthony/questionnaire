<?php

namespace eni\QCMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\Common\Collections\ArrayCollection;
use eni\QCMBundle\Entity\Theme;
use eni\QCMBundle\Form\Type\ThemeType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("admin/theme")
 */
class ThemeController extends Controller
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
     * @Route("/creer", name="theme_create", options={"expose"=true})
     * @Template()
     */
    public function createAction(Request $request)
    {
        
    	$theme = new Theme();

    	// Création du formulaire
    	$form = $this->createForm(new ThemeType(), $theme);
    	$form->handleRequest($request);

    	if ($request->getMethod() == "POST") {

	    	if ($form->isValid()) {
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($theme);
	    		$em->flush();

	    		// TODO : Rediriger vers la liste des thèmes
	    		return $this->redirect($this->generateUrl('accueil'));
	    	}
	    }

        return $this->render('eniQCMBundle:Theme:create.html.twig', array(
        	'form' => $form->createView()));
    }
}