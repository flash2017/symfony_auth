<?php

namespace App\Application\Resource;

use App\Application\DTO\OutputDTO\UserOutpuDTO;
use Symfony\Component\Serializer\SerializerInterface;
class UserResource
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    )
    {
    }

    public function makeRegistrationData(UserOutpuDTO $dto): string
    {
       return $this->serializer->serialize($dto, 'json', ['groups' => ['user:registry']]);
    }
}
