<?php

namespace App\Infrastructure\EventListener;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::RESPONSE)]
final class OnResponseListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;
    public function __invoke(ResponseEvent $event): void
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $duration = microtime(true) - $request->attributes->get('start_time');

        $this->logger->info('Request completed', [
            'status' => $response->getStatusCode(),
            'duration_ms' => round($duration * 1000, 2),
        ]);
    }
}
