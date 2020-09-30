<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        // $this->reportable(function (ValidationException $exception) {
        //     return $this->convertValidationExceptionToResponse($exception, $request);
        // });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $modelName = Str::lower(class_basename($exception->getModel()));

            return response([
                "message" => "Model not found.",
                "errors" => [
                    $modelName => [
                        "No {$modelName} found with the provided id."
                    ]
                ]
            ], Response::HTTP_NOT_FOUND);
        }
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        if ($exception instanceof NotFoundHttpException) {
            return response([
                "message" => "Invalid Url.",
                "errors" => [
                    "url" => [
                        "{$request->fullUrl()} is invalid."
                    ]
                ],
            ], Response::HTTP_NOT_FOUND);
        }
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }
        if ($exception instanceof AuthorizationException) {
            return response([
                "message" => "Not authorized.",
                "errors" => [
                    'user' => [
                        "{$exception->getMessage()}"
                    ]
                ],
            ], Response::HTTP_FORBIDDEN);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response([
                "message" => "Method not allowed.",
                "errors" => [
                    "url" => [
                        "The {$request->method()} method is not supported for {$request->fullUrl()}"
                    ]
                ],
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }
        if ($exception instanceof QueryException) {
            $errorCode = $exception->errorInfo[1];
            if ($errorCode === 1451) {
                return response([
                    "message" => "Resource conflict.",
                    "errors" => [
                        'resource' => [
                            "This resource can't be removed because its instance is present in another table"
                        ]
                    ],
                ], Response::HTTP_CONFLICT);
            }
        }
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }
        return response([
            "message" => "Server Error",
            "errors" => [
                'server' => [
                    "Please try again."
                ]
            ],
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    /**
     * ! OVERRIDDEN FUNCTIONS
     */

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }
        return $this->isFrontend($request) ? $this->invalid($request, $e) : $this->invalidJson($request, $e);
    }

    /**
     * Create a response object from the given authentication exception.
     *
     * @param  \Illuminate\Validation\AuthenticationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message' => $exception->getMessage()], Response::HTTP_UNAUTHORIZED);
    }


    /**
     * ! UTILITY FUNCTIONS
     */
    // Checking if the request is an HTML  request, using collections, find the middleware corresponding to the route and check if it contains 'web'
    private function isFrontend($request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
