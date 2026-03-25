<?php

namespace App\Infrastructure\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\UseCase\RegistrationUserUseCase;
use App\Application\ResponseBuilder\User\UserResponseBuilder;
use App\Application\DTO\Input\RegistrationUserDTO;

#[Route('/api/v1/auth')]
final class AuthenticateController extends AbstractController
{
    public function __construct(
        private RegistrationUserUseCase $registrationUserUseCase,
        private UserResponseBuilder $responseBuilder,
    )
    {
    }

    /**
     * @param RegistrationUserDTO $registrationUserDTO
     * @return JsonResponse
     */
    #[Route('/registration', name: 'auth_registration', methods: ['POST'])]
    public function registration(#[MapRequestPayload] RegistrationUserDTO $registrationUserDTO): JsonResponse
    {
        $userOutputDTO = $this->registrationUserUseCase->registration($registrationUserDTO);

        return $this->responseBuilder->makeRegistrationResponse($userOutputDTO, JsonResponse::HTTP_OK);
    }
}
