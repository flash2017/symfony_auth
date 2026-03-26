<?php

namespace App\Application\UseCase;

use App\Application\DTO\Input\RegistrationUserDTO;
use App\Application\DTO\OutputDTO\UserOutpuDTO;
use App\Application\Factory\UserFactory;
use App\Application\Factory\UserOutPutDTOFactory;
use App\Domain\User\Repository\UserRepositoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private ValidatorInterface $validator,
        private UserFactory $userFactory,
        private UserOutPutDTOFactory $userOutPutDTOFactory,
        private JWTTokenManagerInterface $jwtManager,
    )
    {
    }

    /**
     * @param RegistrationUserDTO $registrationUserDTO
     * @return UserOutpuDTO
     */
    public function registration(RegistrationUserDTO $registrationUserDTO): UserOutpuDTO
    {
        $this->validator->validate($registrationUserDTO);
        $user = $this->userFactory->makeRegistrationUser($registrationUserDTO);

        $user = $this->userRepository->store($user);

        return $this->userOutPutDTOFactory->makeRegistrationOutPutDTO($user, $this->jwtManager->create($user));
    }
}
