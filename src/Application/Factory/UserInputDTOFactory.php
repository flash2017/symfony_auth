<?php

namespace App\Application\Factory;

use App\Application\DTO\Input\RegistrationUserDTO;

class UserInputDTOFactory
{
    /**
     * @param array $data
     * @return RegistrationUserDTO
     */
    public function makeRegistrationUserInputDTO(array $data): RegistrationUserDTO
    {
        $dto = new RegistrationUserDTO();

        $dto->email = $data['email'] ?? null;
        $dto->password = $data['password'] ?? null;

        return $dto;
    }
}
