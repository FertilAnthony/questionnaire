<?php

namespace eni\QCMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;

class SectionType extends AbstractType {

	public function buildForm(FormBuilderInterface $oBuilder, array $tOptions) {
		$oBuilder
				->add('theme', 'entity', array(
					'label' => 'Thème',
					'class' => 'eniQCMBundle:Theme'
				))
				->add('nbQuestion', 'integer', array(
					'label' => 'Nombre de questions',
					'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_DOWN
				))
					
		;
	}

	public function getName() {
		return 'section';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'eni\QCMBundle\Entity\Section'
		));
	}
}