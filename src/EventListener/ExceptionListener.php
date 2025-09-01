<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $statusCode = $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : 500;

        $message = $exception->getMessage() ?: 'Unexpected error';

        consoleLog($message);

        $event->setResponse(new JsonResponse([
            'status' => 'error',
            'code'   => $statusCode,
            'message'=> $statusCode !== 500 ? $message : 'Something went wrong. Internal Server Error',
            'validations' => $statusCode == 400 ? $exception->validations : null
        ], $statusCode));
    }
}
