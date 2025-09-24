<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        // Custom exceptions that should not be reported
        ChatNotFoundException::class,
        MessageDeliveryException::class,
    ];

    public function render($request, Exception $exception)
    {
        if ($exception instanceof ChatNotFoundException) {
            return response()->json(['error' => 'Chat not found.'], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof MessageDeliveryException) {
            return response()->json(['error' => 'Message delivery failed.'], Response::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $exception);
    }
}