<?php

namespace eni\QCMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use eni\QCMBundle\Entity\Inscription;
use Doctrine\Common\Collections\ArrayCollection;

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
				'id' => $inscription->getId(),
				'test' => $inscription->getTest(),
				'tempsEcoule' => $inscription->getTempsEcoule()
			];
		}

        return $this->render('eniQCMBundle:Stagiaire:list_test_en_cours.html.twig', array(
        	'inscriptionsUtilisateur' => $tests));
    }

    /**
     * @Route("/passage_test/{id}", name="passage-test", options={"expose"=true}, defaults={"id"=0})
     * @Template
     */
    public function makeTestAction(Inscription $inscription) {

    	// Il faut récupérer aléatoirement : X questions par thème définis dans les sections d'un test
    	$randomQuestions = new ArrayCollection();
    	$themeRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Theme');
    	$questionRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Question');
    	// On récupère le test lié a l'inscription
    	$test = $inscription->getTest();
    	// On récupère les sections du test
    	$sections = $test->getSections();
    	// pour chaque section du test, on récupère le nombre de question et le thème
    	foreach ($sections as $section) {
    		$nbQuestions = $section->getNbQuestion();
    		var_dump($nbQuestions);
    		$theme = $section->getTheme();
    		// On rècupère les X questions du thème pour la section
    		$randomIdQuestions = $themeRepository->getRandomQuestionIdsByTheme($nbQuestions, $theme);
    		$randomQuestions = $questionRepository->getRandomQuestionsByTheme($randomIdQuestions);
    		// On sauvegarde les questions sélectionnées dans la table questions_tirage
    	}

    	return $this->render('eniQCMBundle:Stagiaire:passage_test.html.twig');
    }
}