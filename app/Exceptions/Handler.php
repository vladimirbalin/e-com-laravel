<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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

    protected $dontReport = [
        BusinessException::class
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if ($this->shouldReport($e)) {
                // Это отличное место для
                // интеграции сторонних сервисов
                // для мониторинга ошибок
            }
        });

        $this->renderable(function (BusinessException $e, Request $request) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getUserMessage(),
                ], Response::HTTP_BAD_REQUEST);
            }

            flash()->alert($e->getUserMessage());

            return session()->previousUrl()
                ? back()
                    ->withInput()
                    ->withErrors(['error' => __($e->getUserMessage())])
                : to_route('home');
        });

        $this->renderable(function (NotFoundHttpException $e) {
            return response()->view('pages.404', [], 404);
        });
    }
}
