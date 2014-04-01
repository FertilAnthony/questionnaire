<?php

namespace eni\QCMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\Common\Collections\ArrayCollection;
use eni\QCMBundle\Entity\Promotion;
use eni\QCMBundle\Form\Type\PromotionType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("admin/promotion")
 */
class PromotionController extends Controller
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
	* @Route("/liste_promo", name="promo_list", options={"expose"=true})
	* @Template()
	*/
	public function listAction(Request $request) {
		$promoRepository = $this->getDoctrine()->getManager()->getRepository('eniQCMBundle:Promotion');
		$allPromos = $promoRepository->findAll();

		$listePromos = [];
		foreach($allPromos as $promo) {
			$listePromos[] = [
				'id' => $promo->getCodePromo(),
				'libelle' => $promo->getLibelle()
			];
		}

		return $this->render('eniQCMBundle:Promotion:list.html.twig', array(
			'listePromos' => $listePromos
		));
	}

    /**
     * @Route("/creer_promo", name="promo_create", options={"expose"=true})
     * @Template()
     */
    public function createAction(Request $request)
    {
        // TODO tester affichage message erreur
    	$promo = new Promotion();

    	// Création du formulaire
    	$form = $this->createForm(new PromotionType(), $promo);
    	$form->handleRequest($request);

    	if ($request->getMethod() == "POST") {
	    	if ($form->isValid()) {
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($promo);
	    		$em->flush();

	    		// TODO : Rediriger vers la liste des promo
	    		return $this->redirect($this->generateUrl('promo_list'));
	    	}
	    }

        return $this->render('eniQCMBundle:Promotion:create.html.twig', array(
        	'form' => $form->createView()));
    }
}