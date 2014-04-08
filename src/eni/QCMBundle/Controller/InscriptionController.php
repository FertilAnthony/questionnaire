<?php

namespace eni\QCMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\Common\Collections\ArrayCollection;
use eni\QCMBundle\Entity\Inscription;
use eni\QCMBundle\Form\Type\InscriptionType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("admin/inscription-test")
 */
class InscriptionController extends Controller
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
	* @Route("/liste_inscription", name="inscription_list", options={"expose"=true})
	* @Template()
	*/
	public function listAction(Request $request) {
		$inscriptionRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Inscription');
		$allInscription = $inscriptionRepository->findAll();

		return $this->render('eniQCMBundle:Inscription:list.html.twig', array(
			'listeInscriptions' => $allInscription
		));
	}

    /**
     * @Route("/creer_inscription", name="inscription_create", options={"expose"=true})
     * @Template()
     */
    public function createAction(Request $request)
    {
        // TODO tester affichage message erreur
    	$inscription = new Inscription();
    	$inscription->setEtat(FALSE);

    	// Création du formulaire
    	$form = $this->createForm(new InscriptionType(), $inscription);
    	$form->handleRequest($request);

    	if ($request->getMethod() == "POST") {
    		$utilisateurs = $form->get('utilisateur')->getData();
    		$test = $form->get('test')->getData();
    		$dureeValidite = $form->get('dureeValidite')->getData();
			if ($form->isValid()) {  
	    		foreach ($utilisateurs as $utilisateur) {
	    			$inscription = new Inscription();
	    			$inscription->setEtat(FALSE);
	    			$inscription->setUtilisateur($utilisateur);
	    			$inscription->setTest($test);
	    			$inscription->setDureeValidite($dureeValidite);
	    			  		
		    		$em = $this->getDoctrine()->getManager();
		    		$em->persist($inscription);
		    		$em->flush();
	    		}
		    	return $this->redirect($this->generateUrl('inscription_list'));
		    }
	    }

        return $this->render('eniQCMBundle:Inscription:create.html.twig', array(
        	'form' => $form->createView()));
    }
}