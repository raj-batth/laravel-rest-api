<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

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

        // return $request->expectsJson()
        //             ? $this->invalidJson($request, $e)
        //             : $this->invalid($request, $e);
        
        return $this->isFrontend($request) ? $this->invalid($request, $e) : $this->invalidJson($request, $e);
    }

    /**
     * ! UTILITY FUNCTIONS
     */
    // Checking if the request is an HTML  request, using collections, find the middleware corresponding to the route and check if it contains 'web'
    private function isFrontend($request) {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
