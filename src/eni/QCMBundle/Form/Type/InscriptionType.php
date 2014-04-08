<?php

namespace eni\QCMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class InscriptionType extends AbstractType {

	public function buildForm(FormBuilderInterface $oBuilder, array $tOptions) {
		$oBuilder
				->add('test', 'entity', array(
					'label' => 'Test',
					'class' => 'eniQCMBundle:Test',
					'required' => true,
					'empty_value' => 'Liste des tests disponibles',
					'empty_data' => null,
				))
				->add('dureeValidite', 'datetime', array(
					'label' => 'Durée de validité',
					'input' => 'datetime',
					'widget' => 'single_text',
					'format' => 'dd/MM/yyyy',
					'attr' => array('class' => 'datepicker', 'size' => 10),
					'required' => true
				))
				->add('utilisateur', 'entity', array(
					'label' => 'Stagiaires',
					'class' => 'eniQCMBundle:Utilisateur',
					'query_builder' => function(EntityRepository $er) {
        				return $er->createQueryBuilder('u')
        						->where('u.type != :formateur')
            					->orderBy('u.nom', 'ASC')
            					->orderBy('u.prenom', 'ASC')
            					->setParameter('formateur', 'formateur');
    				},
    				'multiple' => true,
    				'attr' => array('class' => 'stagiaires'),
    				'required' => true
    			))
					
		;
	}

	public function getName() {
		return 'inscription';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'eni\QCMBundle\Entity\Inscription'
		));
	}
}