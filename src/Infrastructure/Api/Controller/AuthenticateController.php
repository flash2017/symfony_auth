<?php

namespace App\Infrastructure\Api\Controller;

use App\Application\UseCase\MeUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\UseCase\RegistrationUserUseCase;
use App\Application\ResponseBuilder\User\UserResponseBuilder;
use App\Application\DTO\Input\RegistrationUserDTO;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/api/v1/auth')]
final class AuthenticateController extends AbstractController
{
    public function __construct(
        private RegistrationUserUseCase $registrationUserUseCase,
        private MeUseCase $meUseCase,
        private UserResponseBuilder $responseBuilder,
    )
    {
    }

    /**
     * @param RegistrationUserDTO $registrationUserDTO
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    #[Route('/registration', name: 'auth_registration', methods: ['POST'])]
    public function registration(#[MapRequestPayload] RegistrationUserDTO $registrationUserDTO): JsonResponse
    {
        $userOutputDTO = $this->registrationUserUseCase->registration($registrationUserDTO);

        return $this->responseBuilder->makeRegistrationResponse($userOutputDTO, JsonResponse::HTTP_OK);
    }

    /**
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    #[Route('/me', name: 'auth_me', methods: ['GET'])]
    public function me(): JsonResponse
    {
        $user = $this->getUser();

        if ($user === null) {
            $response = $this->responseBuilder->makeBadResponse();
        } else {
            $outputDTO = $this->meUseCase->me($user);
            $response = $this->responseBuilder->makeMeResponse($outputDTO, JsonResponse::HTTP_OK);
        }

        return $response;
    }
}
