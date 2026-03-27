<?php

namespace App\Infrastructure\EventListener;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @uses OnRequestLoggingMiddlewareListener::onRequestLogging()
 * @uses OnRequestLoggingMiddlewareListener::onResponseLogging()
 */
final class OnRequestLoggingMiddlewareListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @param RequestEvent $event
     * @return void
     */
    public function onRequestLogging(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $request->attributes->set('start_time', microtime(true));
        if ($request->headers->get('X-Request-ID') === null) {
            $request->headers->set('X-Request-ID', $this->generateRequestId());
        }

        $this->logger->info('Request received', [
            'method' => $request->getMethod(),
            'uri' => (string) $request->getUri(),
            'request_id' => $request->headers->get('X-Request-ID'),
        ]);
    }

    /**
     * @param ResponseEvent $event
     * @return void
     */
    public function onResponseLogging(ResponseEvent $event): void
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $duration = microtime(true) - $request->attributes->get('start_time');

        $this->logger->info('Request completed', [
            'status' => $response->getStatusCode(),
            'duration_ms' => round($duration * 1000, 2),
            'request_id' => $request->headers->get('X-Request-ID'),
        ]);
    }

    private function generateRequestId(): string
    {
        return bin2hex(random_bytes(16));
    }
}
