<?php

namespace eni\QCMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class UtilisateurType extends AbstractType {

	public function buildForm(FormBuilderInterface $oBuilder, array $tOptions) {
		$oBuilder
				->add('username', 'text', array(
					'label' => 'Pseudo'
				))
				->add('prenom', 'text', array(
					'label' => 'Prénom'
				))
				->add('nom', 'text', array(
					'label' => 'Nom'
				))
				->add('email', 'text', array(
					'label' => 'Email'
				))
				->add('plainPassword', 'hidden', array(
					'label' => 'Mot de passe',
					'data' => 'Pa$$w0rd'
				))
				->add('repeatPassword', 'hidden', array(
					'label' => 'Mot de passe',
					'mapped' => false, // ce champ n'existe pas sur l'objet, mais on en a besoin dans le formulaire,
					'data' => 'Pa$$w0rd'
				))
				->add('type', 'choice', array(
					'label' => 'Type',
					'choices' => array('formateur' => 'Formateur', 'stagiaire' => 'Stagiaire'),
					'preferred_choices' => array('stagiaire')
				))
				// TODO -> Penser à récupérer le codePromo
				->add('promotion', 'entity', array(
					'label' => 'Promotion',
					'class' => 'eniQCMBundle:Promotion',
					'query_builder' => function(EntityRepository $er) {
        				return $er->createQueryBuilder('p')
            					->orderBy('p.codePromo', 'ASC');
    				},
				))
		;
	}

	public function getName() {
		return 'utilisateur';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'eni\QCMBundle\Entity\Utilisateur'
		));
	}
}