<?php

namespace eni\QCMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PromotionType extends AbstractType {

	public function buildForm(FormBuilderInterface $oBuilder, array $tOptions) {
		$oBuilder
				->add('codePromo', 'text', array(
					'label' => 'Code Promotion'
				))
				->add('libelle', 'text', array(
					'label' => 'Libellé'
				));
	}

	public function getName() {
		return 'promotion';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'eni\QCMBundle\Entity\Promotion'
		));
	}
}