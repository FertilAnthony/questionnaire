<?php

namespace eni\QCMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionType extends AbstractType {

	public function buildForm(FormBuilderInterface $oBuilder, array $tOptions) {
		$oBuilder
				->add('themes', 'entity', array(
					'label' => 'Thème',
	                'required' => true,
	                'class' => "eniQCMBundle:Theme",
	                'multiple' => true
	            ))
				->add('type', 'choice', array(
					'required' => true,
					'empty_value' => 'Type de question',
					'empty_data' => null,
	                'choices' => array(
	                    "simple" => "Une seul réponse possible",
	                    "multiple" => "Réponses multiple possibles"
	                )
	            ))
	            ->add('enonce', 'ckeditor', array(
	            	'label' => 'Enoncé',
	            	'required' => true
	            ))
	            ->add('reponses', 'collection', array(
	                'required' => true,
	                'type' => new ReponseType(),
	                'allow_add'    => true,
	                'allow_delete' => true,
	                'by_reference' => false
	            ));
	}

	public function getName() {
		return 'question';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'eni\QCMBundle\Entity\Question'
		));
	}
}