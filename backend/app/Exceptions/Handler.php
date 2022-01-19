<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use \GuzzleHttp\Exception\ServerException;
use \Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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
    }

    public function render($request, Throwable $exception)
    {

        # 認証できていない場合401
        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json(
                [
                    'message' => $exception->getMessage(),
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        # サーバーがダウンしている場合500
        if ($exception instanceof ServerException) {
            return response()->json(
                [
                    'message' => $exception->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return parent::render($request, $exception);
    }
}
