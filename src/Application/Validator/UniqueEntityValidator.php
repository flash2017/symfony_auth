<?php

namespace App\Application\Validator;

use App\Application\Validator\Constraint\UniqueEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueEntityValidator extends ConstraintValidator
{

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueEntity || $value === null) {
            return;
        }

        // Поиск сущности по полю
        $existing = $this->entityManager->getRepository($constraint->entityClass)
            ->findOneBy([$constraint->field => $value]);

        if (empty($existing) === false) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ field }}', $constraint->field)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
