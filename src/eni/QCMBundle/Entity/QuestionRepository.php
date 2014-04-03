<?php

namespace eni\QCMBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * QuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends EntityRepository
{
    protected $validator;

    
    public function getRandomQuestionsByTheme($nbQuestionIds) {

        $qb = $this->createQueryBuilder('q');

        $questions = [];
        foreach ($nbQuestionIds as $id) {
            $qb->where('q.id = :id')
                ->setParameter('id', $id);
            $questions[] = $qb->getQuery()
                ->getResult();
        }

        return $questions;
    }


    /**
     * @param mixed $validator
     */
    public function setValidator(\Symfony\Component\Validator\Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return mixed
     */
    public function getValidator()
    {
        if(is_null($this->validator)){
            $ValidatorBuilder = Validation::createValidatorBuilder();
            $ValidatorBuilder->enableAnnotationMapping();
            $this->validator = $ValidatorBuilder->getValidator();
        }
        return $this->validator;
    }

    public function add(question $question){
        $errorsFields = $this->getValidator()->validate($question);
        if (count($errorsFields) > 0) {
            throw new ExceptionValidation($errorsFields);
        }
        $this->getEntityManager()->persist($question);
        $this->getEntityManager()->flush();
        return $question;
    }
}
