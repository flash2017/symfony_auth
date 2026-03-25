<?php

namespace App\Application\ResponseBuilder\User;

use App\Application\DTO\OutputDTO\UserOutpuDTO;
use App\Application\Resource\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserResponseBuilder
{
    public function __construct(
        private UserResource $resource
    )
    {
    }

    public function makeRegistrationResponse(UserOutpuDTO $userOutputDTO, int $status = JsonResponse::HTTP_OK, array $headers = []): JsonResponse
    {
        $output = $this->resource->makeRegistrationData($userOutputDTO);

        return new JsonResponse($output, $status, $headers, true);
    }
}
