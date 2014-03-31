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
use eni\QCMBundle\Form\Type\TestType;

/**
 * @Route("admin/test")
 */
class AdminController extends Controller
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
     * @Route("/creer", name="test_create", options={"expose"=true})
     * @Template()
     */
    public function createAction(Request $request)
    {
        
    	$test = new Test();
    	$test->setFormateur($oUtilisateurConnecte);

    	if ($request->getMethode() == "POST") {
    		// Création du formulaire
	    	$form = $this->createForm(new TestType(), $test);
	    	$form->handleRequest($request);

	    	if ($form->isValid()) {
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($test);
	    		$em->flush();

	    		$this->get('session')->getFlashBag()->add('Création du test réalisée avec succès');

	    		// TODO : Rediriger vers la liste des tests
	    		return $this->redirect($this->generateUrl('accueil'));
	    	}
	    }

        return $this->render('eniQCMBundle:Test:create.html.twig', array(
        	'form' => $form->createForm));
    }
}