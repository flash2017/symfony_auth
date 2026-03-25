<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\Email;

interface UserRepositoryInterface
{
    /**
     * @param Email $email
     * @return null|User
     */
    public function findByEmail(Email $email): ?User;

    /**
     * @param User $user
     * @return User
     */
    public function store(User $user, bool $isFlush = true): User;

}
