<?php

namespace App\Application\DTO\Input;

use App\Application\Validator\Constraint\UniqueEntity;
use App\Domain\User\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationUserDTO
{
    /**
     * @var string|null
     */
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Email]
    #[UniqueEntity(entityClass: User::class, field: "email", message: 'This value {{ value }} is already in use')]
    public ?string $email;
    /**
     * @var string|null
     */
    #[Assert\NotBlank(allowNull: false)]
    public ?string $password;
}
