<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\ValueObject\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Email $email
     * @return User|null
     */
    public function findByEmail(Email $email): ?User
    {
        $users = $this->findBy(['email' => $email]);
        $user = array_first($users);

        return $user ?? null;
    }

    /**
     * @param User $user
     * @param bool $isFlush
     * @return User
     */
    public function store(User $user, bool $isFlush = true): User
    {
        $this->getEntityManager()->persist($user);

        if ($isFlush === true) {
            $this->getEntityManager()->flush();
        }

        return $user;
    }
}
