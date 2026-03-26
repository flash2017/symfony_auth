<?php

namespace App\Application\Resource;

use App\Application\DTO\OutputDTO\UserOutpuDTO;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
class UserResource
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    )
    {
    }

    /**
     * @param UserOutpuDTO $dto
     * @return string
     * @throws ExceptionInterface
     */
    public function makeRegistrationData(UserOutpuDTO $dto): string
    {
       return $this->serializer->serialize($dto, 'json', ['groups' => ['user:registry']]);
    }

    /**
     * @param UserOutpuDTO $dto
     * @return string
     * @throws ExceptionInterface
     */
    public function makeMe(UserOutpuDTO $dto)
    {
        return $this->serializer->serialize($dto, 'json', ['groups' => ['user:me']]);
    }
}
