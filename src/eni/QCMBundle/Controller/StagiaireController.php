<?php

namespace eni\QCMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/stagiaire")
 */
class StagiaireController extends Controller
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
     *
     * @Route("/test_en_cours", name="stagiaire_test_en_cours", options={"expose"=true})
     * @Template()
     */
    public function indexAction()
    {
       	
        $InscriptionRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Inscription');
		$inscriptionsUtilisateur = $InscriptionRepository->getInscriptionsEnCoursUtilisateur($this->oUtilisateurConnecte);

		$tests = [];
		foreach ($inscriptionsUtilisateur as $inscription) {
			$tests[] = [
				'test' => $inscription->getTest(),
				'tempsEcoule' => $inscription->getTempsEcoule()
			];
		}

        return $this->render('eniQCMBundle:Stagiaire:list_test_en_cours.html.twig', array(
        	'inscriptionsUtilisateur' => $tests));
    }
}