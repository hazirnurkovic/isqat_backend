<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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


    public function render($request , Throwable $exception )
    {
        if($exception instanceof ModelNotFoundException)
        {
            $model = $exception->getModel();
            $model = class_basename($model);

            return response()->json([
                'message' => "The $model doesn'te exist."
            ], 404);
        }

        if($exception instanceof NotFoundHttpException)
        {
            return response()->json([
                'message' => "The resource doesn'te exist."
            ], 404);
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
