<?php

namespace eni\QCMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;

class TestType extends AbstractType {

	public function buildForm(FormBuilderInterface $oBuilder, array $tOptions) {
		$oBuilder
				->add('nom', 'text', array(
					'label' => 'Libellé',
					'attr' => array('class' => 'form-control')
				))
				->add('description', 'textarea', array(
					'label' => 'Description',
					'attr' => array('class' => 'form-control'),
					'required' => false
				))
				->add('duree', 'time', array(
					'label' => 'Durée',
					'attr' => array('class' => 'form-control')
				))
				->add('seuil', 'integer', array(
					'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_DOWN,
					'attr' => array('class' => 'form-control')
				))
				->add('sections', 'collection', array(
					'required' => 'false',
					'type' => new SectionType(),
					'allow_add' => true,
					'allow_delete' => true,
					'by_reference' => false,
					'attr' => array('class' => 'form-control')
					
				));
	}

	public function getName() {
		return 'test';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'eni\QCMBundle\Entity\Test'
		));
	}
}