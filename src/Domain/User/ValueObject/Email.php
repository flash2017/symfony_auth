<?php
declare(strict_types=1);

namespace App\Domain\User\ValueObject;

use InvalidArgumentException;

/**
 * ValueObject Email
 */
final class Email
{
    /**
     * @param string $email
     */
    public function __construct(private readonly string $email)
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email');
        }
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->email;
    }
}
