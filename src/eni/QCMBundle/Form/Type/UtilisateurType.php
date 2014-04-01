<?php

namespace eni\QCMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UtilisateurType extends AbstractType {

	public function buildForm(FormBuilderInterface $oBuilder, array $tOptions) {
		$oBuilder
				->add('username', 'text', array(
					'label' => 'Login'
				))
				->add('email', 'text', array(
					'label' => 'Email'
				))
				->add('plainPassword', 'password', array(
					'label' => 'Mot de passe'
				))
				->add('repeatPassword', 'password', array(
					'label' => 'Mot de passe',
					'mapped' => false // ce champ n'existe pas sur l'objet, mais on en a besoin dans le formulaire
				))
				->add('prenom', 'text', array(
					'label' => 'Prénom'
				))
				->add('nom', 'text', array(
					'label' => 'Nom'
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