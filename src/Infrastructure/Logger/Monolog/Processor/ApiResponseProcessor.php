<?php
declare(strict_types=1);

namespace App\Infrastructure\Logger\Monolog\Processor;

use Monolog\LogRecord;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

class ApiResponseProcessor
{
    private ?int $statusCode = null;
    private ?float $startTime = null;
    private ?string $requestId = null;

    public function __construct() {
        $this->startTime = microtime(true);
    }

    /**
     * Вызывается как процессор логов (добавляет данные в запись лога)
     */
    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra['api'] = [
            'status_code' => $this->statusCode ?? 'unknown',
            'execution_time_ms' => $this->getExecutionTime(),
            'request_id' => $this->requestId ?? $this->generateRequestId(),
        ];

        return $record;
    }

    /**
     * Вызывается как слушатель события kernel.terminate
     * ВАЖНО: Тип аргумента - TerminateEvent
     */
    public function terminate(TerminateEvent $event): void
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        $this->statusCode = $response->getStatusCode();
        $this->requestId = $request->headers->get('X-Request-ID') ?? $this->generateRequestId();
    }

    private function getExecutionTime(): int
    {
        return $this->startTime !== null
            ? (int) ((microtime(true) - $this->startTime) * 1000)
            : 0;
    }

    private function generateRequestId(): string
    {
        return bin2hex(random_bytes(16));
    }
}
