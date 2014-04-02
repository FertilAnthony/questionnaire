<?php

namespace eni\QCMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use eni\QCMBundle\Form\Type\ProfileType;

class UtilisateurController extends Controller {

	/**
	* @var Utilisateur
	*/
	private $utilisateurConnecte = NULL;

	public function  preExecute() {
		$oSecurityContext = $this->get('security.context');
		if ($oSecurityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			$this->utilisateurConnecte = $oSecurityContext->getToken()->getUser();
		}
	}

	/**
	* @Route("admin/liste_utilisateur", name="user_list", options={"expose"=true})
	* @Template()
	*/
	public function utilisateurAction() {
		$utilisateurRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Utilisateur');
		$allUsers = $utilisateurRepository->findAll();

		$listeUtilisateurs = [];
		foreach ($allUsers as $utilisateur) {
			$listeUtilisateurs[] = [
				'id' => $utilisateur->getId(),
				'nom' => $utilisateur->getNom(),
				'prenom' => $utilisateur->getPrenom(),
				'email' => $utilisateur->getEmail()
			];
		}

		return $this->render('eniQCMBundle:Utilisateur:list.html.twig', array(
			'listeUtilisateurs' => $listeUtilisateurs
		));
	}

	/**
	* @Route("/profil", name="user_profile", options={"expose"=true})
	* @Template()
	*/
	public function profileAction(Request $request) {
		
		$form = $this->createForm(new ProfileType(), $this->utilisateurConnecte);
    	$form->handleRequest($request);

    	if ($request->getMethod() == "POST") {

	    	if ($form->isValid()) {
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($this->utilisateurConnecte);
	    		$em->flush();

	    		return $this->redirect($this->generateUrl('user_list'));
	    	}
	    }

		return $this->render('eniQCMBundle:Utilisateur:profile.html.twig', array(
			'form' => $form->createView()
		));
	}
}