<?php

namespace App\Application\UseCase;

use App\Application\DTO\Input\RegistrationUserDTO;
use App\Application\DTO\OutputDTO\UserOutpuDTO;
use App\Application\Factory\UserFactory;
use App\Application\Factory\UserInputDTOFactory;
use App\Application\Factory\UserOutPutDTOFactory;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Api\Exception\ApiException;
use App\Infrastructure\Api\Exception\ValidationException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private ValidatorInterface $validator,
        private UserFactory $userFactory,
        private UserInputDTOFactory $userInputDTOFactory,
        private UserOutPutDTOFactory $userOutPutDTOFactory,
        private JWTTokenManagerInterface $jwtManager,
    )
    {
    }

    /**
     * @param Request $request
     * @return RegistrationUserDTO
     * @throws ApiException|ValidationException
     */
    public function parseRequestToRegistrationUserDTO(Request $request): RegistrationUserDTO
    {
        try {
            $dataDTO = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new ApiException($exception->getMessage(), 422);
        }

        $registrationUserDTO = $this->userInputDTOFactory->makeRegistrationUserInputDTO($dataDTO);

        $constraintViolation = $this->validator->validate($registrationUserDTO);
        if ($constraintViolation->count() > 0) {
            throw new ValidationException($constraintViolation);
        }

        return $registrationUserDTO;
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
