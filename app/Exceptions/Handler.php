<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;
use Predis\Connection\ConnectionException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
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
        ConnectionException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
   
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException|QueryException $exception, $request) {
            if ($this->shouldReturnJson($request, $exception)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The resource you are trying to access can not be found on this server.',
                ], Response::HTTP_NOT_FOUND);
            }
        });

        $this->renderable(function (AuthenticationException $exception, $request) {
            if ($this->shouldReturnJson($request, $exception)) {
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage(),
                ], Response::HTTP_UNAUTHORIZED);
            }
        });

        $this->renderable(function (Throwable $exception, $request) {
            if ($this->shouldReturnJson($request, $exception)) {
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage(),
                ], 500);
            }
        });
    }

    private function generalExceptionResponse(Exception $exception): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $exception->getMessage(),
        ], $exception->getCode());
    }
}
