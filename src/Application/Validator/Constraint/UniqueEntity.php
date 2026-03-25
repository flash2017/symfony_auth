<?php

namespace App\Application\Validator\Constraint;

use Attribute;
use Symfony\Component\Validator\Constraint;
use App\Application\Validator\UniqueEntityValidator;

/**
 * валидация уникальности по значению.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class UniqueEntity extends Constraint
{
    public function __construct(public string $entityClass,
                                public string $field,
                                public string $message = 'This value {{ value }} is already in use in field {{ field }}',
                                mixed $options = null,
                                ?array $groups = null,
                                mixed $payload = null
    )
    {
        parent::__construct($options, $groups, $payload);
    }

    public function validatedBy(): string
    {
        return UniqueEntityValidator::class;
    }

}
