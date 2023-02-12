<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponses;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponses;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        BadRequestException::class,
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $exception, $request) {
            return $this->handleException($exception, $request);
        });
    }


    public function handleException(Throwable $exception, $request)
    {
        if ($exception instanceof ValidationException) {
            return $this->validationResponse($exception->errors());
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->notFoundResponse('Unable to locate model resource', 'model_not_found');
        }

        if ($exception instanceof RouteNotFoundException) {
            return $this->notFoundResponse($exception->getMessage());
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->notFoundResponse("We cannot access the resource you are looking for");
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->badRequestResponse($exception->getMessage());
        }

        if ($exception instanceof BadRequestException) {
            return $this->badRequestResponse($exception->getMessage());
        }
    }
}