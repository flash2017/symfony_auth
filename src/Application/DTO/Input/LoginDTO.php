<?php

declare(strict_types=1);

namespace App\Application\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

class LoginDTO
{
    /**
     * @var string|null
     */
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Email]
    public ?string $email;
    /**
     * @var string|null
     */
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\PasswordStrength]
    public ?string $password;
}
