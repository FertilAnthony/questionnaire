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
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("admin/test")
 */
class TestController extends Controller
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
	* @Route("/liste_test", name="test_list", options={"expose"=true})
	* @Template()
	*/
	public function listAction() {
		$testRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Test');
		$allTests = $testRepository->findAll();

		return $this->render('eniQCMBundle:Test:list.html.twig', array(
			'listeTests' => $allTests
		));
	}

    /**
     * @Route("/creer_test", name="test_create", options={"expose"=true})
     * @Template()
     */
    public function createAction(Request $request)
    {
        // TODO tester affichage message erreur
    	$test = new Test();
    	$test->setFormateur($this->oUtilisateurConnecte);

    	// Création du formulaire
    	$form = $this->createForm(new TestType(), $test);
    	$form->handleRequest($request);

    	if ($request->getMethod() == "POST") {
	    	if ($form->isValid()) {
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($test);
	    		$em->flush();

	    		// TODO : Rediriger vers la liste des tests
	    		return $this->redirect($this->generateUrl('test_list'));
	    	}
	    }

        return $this->render('eniQCMBundle:Test:create.html.twig', array(
        	'form' => $form->createView()));
    }
}