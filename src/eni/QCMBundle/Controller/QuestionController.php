<?php

namespace eni\QCMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\Common\Collections\ArrayCollection;
use eni\QCMBundle\Entity\Question;
use eni\QCMBundle\Form\Type\QuestionType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("admin/question")
 */
class QuestionController extends Controller
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
	* @Route("/liste_question", name="question_list", options={"expose"=true})
	* @Template()
	*/
	public function listAction(Request $request) {
		$questionRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Question');
		$allQuestions = $questionRepository->findAll();

		$listeQuestions = [];
		foreach($allQuestions as $question) {
			$listeQuestions[] = [
				'id' => $question->getid(),
				'enonce' => $question->getEnonce(),
				'type' => $question->getType()
			];
		}

		return $this->render('eniQCMBundle:Question:list.html.twig', array(
			'listeQuestions' => $allQuestions
		));
	}

    /**
     * @Route("/creer_question", name="question_create", options={"expose"=true})
     * @Template()
     */
    public function createAction(Request $request)
    {
        // TODO tester affichage message erreur
    	$question = new Question();

    	// Création du formulaire
    	$form = $this->createForm(new QuestionType(), $question);
    	$form->handleRequest($request);

    	if ($request->getMethod() == "POST") {
	    	if ($form->isValid()) {
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($question);
	    		$em->flush();

	    		return $this->redirect($this->generateUrl('question_list'));
	    	}
	    }

        return $this->render('eniQCMBundle:Question:create.html.twig', array(
        	'form' => $form->createView()));
    }
}