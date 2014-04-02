<?php

namespace eni\QCMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReponseType extends AbstractType {

	public function buildForm(FormBuilderInterface $oBuilder, array $tOptions) {
		$oBuilder
				->add('libelle', 'text', array(
					'label' => 'Libellé',
	                'required' => true
	            ))
				->add('estBonne', 'checkbox', array(
	                'required' => false,
	                "label" => "Réponse exacte ?"
	        	));
	}

	public function getName() {
		return 'reponse';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'eni\QCMBundle\Entity\Reponse'
		));
	}
}