<?php

namespace App\Application\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationUserDTO
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
    public ?string $password;
}
