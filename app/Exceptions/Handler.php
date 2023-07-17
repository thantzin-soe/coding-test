<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
            if ($exception instanceof ModelNotFoundException) {
                $model = explode('\\', $exception->getModel());
                $model = end($model);
                return Response::error($model.' not found.', HttpResponse::HTTP_NOT_FOUND);
            }

            if ($exception instanceof NotFoundHttpException) {
                return Response::error('Request not found.', HttpResponse::HTTP_NOT_FOUND);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return Response::error($exception->getMessage(), HttpResponse::HTTP_METHOD_NOT_ALLOWED);
            }

            if ($exception instanceof ValidationException) {
                return Response::error(collect($exception->errors())->first()[0], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($exception instanceof AuthenticationException) {
                return Response::error($exception->getMessage(), HttpResponse::HTTP_UNAUTHORIZED);
            }

            if ($exception instanceof AuthorizationException) {
                return Response::error($exception->getMessage(), HttpResponse::HTTP_FORBIDDEN);
            }

            if ($exception instanceof UnauthorizedException) {
                return Response::error($exception->getMessage(), HttpResponse::HTTP_FORBIDDEN);
            }

            if ($exception instanceof ThrottleRequestsException) {
                return Response::error($exception->getMessage(), HttpResponse::HTTP_TOO_MANY_REQUESTS);
            }

            return parent::render($request, $exception);
        }

        return parent::render($request, $exception);
    }
}
