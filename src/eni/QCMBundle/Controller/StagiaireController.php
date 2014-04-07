<?php

namespace eni\QCMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use eni\QCMBundle\Entity\Inscription;
use eni\QCMBundle\Entity\QuestionTirage;
use eni\QCMBundle\Entity\Question;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
     * @Route("/generate_question/{id}", name="generate-question", options={"expose"=true}, defaults={"id"=0})
     * @Method({"POST"})
     */
    public function generateQuestionsTestAction(Request $request, Inscription $inscription) {

        // TODO : Il faudra mettre en place une vérification pour la reprise de test
    	// Il faut récupérer aléatoirement : X questions par thème définis dans les sections d'un test
    	$randomQuestions = [];
    	$themeRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Theme');
    	$questionRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Question');
    	// On récupère le test lié a l'inscription
    	$test = $inscription->getTest();
    	// On récupère les sections du test
    	$sections = $test->getSections();
    	// pour chaque section du test, on récupère le nombre de question et le thème
    	foreach ($sections as $section) {
    		$nbQuestions = $section->getNbQuestion();
    		$theme = $section->getTheme();
    		// On rècupère les X questions du thème pour la section
    		$randomIdQuestions = $themeRepository->getRandomQuestionIdsByTheme($nbQuestions, $theme);
    		$randomQuestions = $questionRepository->getRandomQuestionsByTheme($randomIdQuestions);
    		// On sauvegarde les questions sélectionnées dans la table questions_tirage
            foreach ($randomQuestions as $question) {
                $questionTirage = new QuestionTirage();
                $questionTirage->setQuestion($question[0]);
                $questionTirage->setInscription($inscription);
                $questionTirage->setEstMarquee(false);

                // On persite et on sauvegarde
                $em = $this->getDoctrine()->getManager();
                $em->persist($questionTirage);
                $em->flush();
            }
    	}

        return new Response('ok');

    }

    /**
     * @Route("/passage_test/{id}", name="passage-test", options={"expose"=true}, defaults={"id"=0})
     * @Template()
     */
    public function makeTestAction(Inscription $inscription, Question $question) {

        // Récupération de toutes les questions ainsi que du temps pour le passage du test
        $questionTirage = new QuestionTirage();
        $questions = [];
        $questionTirageRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:QuestionTirage');
        $questionRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Question');
        $questionsTirage = $questionTirageRepository->getQuestionsTirage();

        foreach($questionsTirage as $questionTirage) {
            $question = $questionTirage->getQuestion();
            $reponses = $question->getReponses();
            $libelleReponses = [];
            foreach($reponses as $reponse) {
                $libelleReponses[] = [
                    'id' => $reponse->getId(),
                    'libelle' => $reponse->getLibelle()
                ];
            }
            $questions[] =  [
                'id' => $question->getId(),
                'enonce' => $question->getEnonce(),
                'type' => $question->getType(),
                'reponses' => $libelleReponses,
                'idQuestionTirage' => $questionTirage->getId()
            ];
        }

        // On récupère le test lié a l'inscription
        $test = $inscription->getTest();
        $dureeTest = $test->getDuree();

        return $this->render('eniQCMBundle:Stagiaire:passage_test.html.twig',array(
            'questions' => $questions,
            'dureeTest' => $dureeTest));
    }

    /**
     * @Route("/save_question", name="save-question", options={"expose"=true})
     * @Method({"POST"})
     */
    public function saveQuestionTirageAction(Request $request) {

        $reponses = new ArrayCollection();
        $idQuestionTirage = $_POST['idQuestionTirage'];
        $reponseRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Reponse');
        // On récupère la question tirage
        $questionTirageRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:QuestionTirage');
        $questionTirage = $questionTirageRepository->findOneById($idQuestionTirage);

        // On vérifie si la question est marquée
        if ($_POST['estMarquee']) {
            $questionTirage->setEstMarquee(true);
        }

        if (!empty($_POST['responses'])) {
            $reponsesId = $_POST['responses'];
            foreach ($reponsesId as $reponseId) {
                $reponse = $reponseRepository->findOneById($reponseId);
                $reponses->add($reponse);
            }
            $questionTirage->setReponses($reponses);
        }

        // On persite et on sauvegarde
        $em = $this->getDoctrine()->getManager();
        $em->persist($questionTirage);
        $em->flush();

        return new Response('ok');
    }
}