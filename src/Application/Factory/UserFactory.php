<?php

namespace App\Application\Factory;

use App\Application\DTO\Input\RegistrationUserDTO;
use App\Domain\User\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    /**
     * @param RegistrationUserDTO $registrationUserDTO
     * @return User
     */
    public function makeRegistrationUser(RegistrationUserDTO $registrationUserDTO): User
    {
        $user = new User();

        $user->setEmail($registrationUserDTO->email);
        $user->setCreatedAt(new \DateTimeImmutable('now'));

        $user->setPassword($this->passwordHasher->hashPassword($user, $registrationUserDTO->password));

        return $user;
    }
}
