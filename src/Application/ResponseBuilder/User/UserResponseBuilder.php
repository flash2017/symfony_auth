<?php

namespace App\Application\ResponseBuilder\User;

use App\Application\DTO\OutputDTO\UserOutpuDTO;
use App\Application\Resource\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class UserResponseBuilder
{
    public function __construct(
        private UserResource $resource
    )
    {
    }

    /**
     * @param string|null $message
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public function makeBadResponse(string $message = null, int $status = JsonResponse::HTTP_NOT_FOUND, array $headers = []): JsonResponse
    {
        $data = is_null($message) ? [] : ['message' => $message];
        return  new JsonResponse($data, $status, $headers, false);
    }

    /**
     * @param UserOutpuDTO $userOutputDTO
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function makeRegistrationResponse(UserOutpuDTO $userOutputDTO, int $status = JsonResponse::HTTP_OK, array $headers = []): JsonResponse
    {
        $output = $this->resource->makeRegistrationData($userOutputDTO);

        return new JsonResponse($output, $status, $headers, true);
    }

    /**
     * @param UserOutpuDTO $userOutputDTO
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function makeMeResponse(UserOutpuDTO $userOutputDTO, int $status = JsonResponse::HTTP_OK, array $headers = []): JsonResponse
    {
        $output = $this->resource->makeMe($userOutputDTO);

        return new JsonResponse($output, $status, $headers, true);
    }
}
