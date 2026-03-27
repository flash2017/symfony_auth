<?php

namespace App\Infrastructure\Api\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use \RuntimeException;
class ApiException extends RuntimeException implements HttpExceptionInterface
{
    /**
     * @var array
     */
    private array $context;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, array $context = array())
    {
        $this->context = $context;
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
