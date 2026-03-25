<?php

namespace App\Application\Factory;

use App\Application\DTO\OutputDTO\UserOutpuDTO;
use App\Domain\User\Entity\User;

class UserOutPutDTOFactory
{
    public function makeRegistrationOutPutDTO(User $user, string $jwtToken): UserOutpuDTO
    {
        $registrationUSerDTO = new UserOutpuDTO();

        $registrationUSerDTO->id = $user->getId();
        $registrationUSerDTO->email = $user->getEmail();
        $registrationUSerDTO->jwtToken = $jwtToken;
        $registrationUSerDTO->roles = $user->getRoles();

        return $registrationUSerDTO;
    }
}
