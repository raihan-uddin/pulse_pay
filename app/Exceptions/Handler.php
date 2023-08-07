<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
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

    /**
     * @throws Throwable
     */
    public function render($request, Throwable $exception): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response|RedirectResponse
    {
        // Handle "Class not found" error and return JSON response
        if ($exception instanceof \Error) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $exception->getMessage(),
            ], 500);
        }

        // Handle "Undefined property" error for $apiVersion
        if ($exception instanceof \ErrorException && str_contains($exception->getMessage(), 'Undefined property')) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $exception->getMessage(),
            ], 500);
        }

        // Handle database query exceptions and return JSON response
        if ($exception instanceof QueryException) {
            $errorCode = $exception->getCode();
            $errorMessage = 'Database error: '.$exception->getMessage();
            //            $errorMessage = 'Something went wrong with the database query.';

            // You can provide additional details to the frontend team
            // For example, you can include the query that caused the error
            $query = $exception->getSql();

            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $errorMessage,
                'query' => $query, // Uncomment this line to include the query
                'code' => $errorCode,
            ], 500);
        }

        // Handle HTTP exceptions and return JSON response
        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();

            return response()->json(['error' => $exception->getMessage()], $statusCode);
        }

        return parent::render($request, $exception);
    }
}
