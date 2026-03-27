<?php

namespace App\Infrastructure\Api\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends ApiException
{
    public function __construct(ConstraintViolationListInterface $errors, string $message = 'Validation failed')
    {
        parent::__construct($message, 422, null, ['errors' => $errors]);
    }
}
