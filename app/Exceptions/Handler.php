<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if (!Auth::guest()) {
            if (Auth::user()->role > 8) {
                return parent::render($request, $e);
            }

        }

        // 404 page when a model is not found
        if ($e instanceof ModelNotFoundException) {
            return response()->view('errors.404', [], 404);
        }

        // Custom error 500 view on production
        if (app()->environment() == 'production') {
            return response()->view('errors.500', [], 500);
        }

        return parent::render($request, $e);
    }
}
