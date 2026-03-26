<?php

declare(strict_types=1);

namespace App\Application\DTO\OutputDTO;

use Symfony\Component\Serializer\Attribute\Groups;

class UserOutpuDTO
{
    #[Groups(['user:registry', 'user:me'])]
    public ?int $id = null;

    #[Groups(['user:registry', 'user:me'])]
    public ?string $email = null;
    #[Groups('user:registry')]
    public ?string $jwtToken = null;

    #[Groups(['user:registry', 'user:me'])]
    public ?array $roles = null;
    #[Groups('user:registry')]
    public ?string $userIdentifier = null;
}
