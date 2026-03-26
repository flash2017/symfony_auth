<?php

namespace App\Infrastructure\EventListener;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::REQUEST)]
final class OnRequestListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $request->attributes->set('start_time', microtime(true));
        $this->logger->info('Request received', [
            'method' => $request->getMethod(),
            'uri' => (string) $request->getUri(),
        ]);
    }
}
