<?php

namespace App\Infrastructure\EventListener;


use App\Infrastructure\Api\Exception\ApiException;
use App\Infrastructure\Api\Exception\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\ConstraintViolationList;

final class ApiExceptionListener
{
    #[AsEventListener]
    public function onExceptionEvent(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof ValidationException) {
            $context = $exception->getContext();
            $errors = $this->parseViolationsToArray($context['errors']);

            $event->setResponse(new JsonResponse(['errors' => $errors], 422));

        } elseif ($exception instanceof ApiException) {
            $event->setResponse(new JsonResponse(['errors' => $exception->getMessage()], 422));
        }
    }

    /**
     * @param ConstraintViolationList $list
     * @return array
     */
    protected function parseViolationsToArray(ConstraintViolationList $list): array
    {
        $messages = [];
        foreach ($list as $error) {
            $messages[$error->getPropertyPath()][] = $error->getMessage();
        }

        return $messages;
    }
}
