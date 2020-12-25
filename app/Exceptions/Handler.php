<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


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
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
    // This will replace our 404 response with
    // a JSON response.
    if (is_a($exception, 'Illuminate\Validation\ValidationException')) {
        return response()->json(['status' => 400, 'message' => $exception->errors()], 400);
    }
    if (is_a($exception, 'Illuminate\Database\Eloquent\ModelNotFoundException') || is_a($exception, 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException') ) {
        return response()->json(['status' => 404, 'message' => 'Resource not found'], 404);
    }
    if (is_a($exception, 'Symfony\Component\HttpKernel\Exception\HttpException')){
      return response()->json(['status' => $exception->getStatusCode(), 'message' => $exception->getMessage()], $exception->getStatusCode());
    } else {
      return parent::render($request, $exception);
    }
    }
}
