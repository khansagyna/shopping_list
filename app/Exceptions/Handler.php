<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * Daftar jenis exception yang tidak akan dilaporkan.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * Daftar input yang tidak boleh dimasukkan ke dalam sesi pada validasi.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Tangani exception yang masuk.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Override render method untuk memastikan API selalu mengembalikan JSON.
     */
    public function render($request, Throwable $exception)
    {
        // Jika request dari API, kembalikan dalam format JSON
        if ($request->expectsJson()) {
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $exception->errors(),
                ], 422);
            }

            if ($exception instanceof AuthenticationException) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 401);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'Route tidak ditemukan',
                ], 404);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'message' => 'Metode HTTP tidak diperbolehkan',
                ], 405);
            }

            return response()->json([
                'message' => $exception->getMessage() ?: 'Terjadi kesalahan server',
            ], 500);
        }

        return parent::render($request, $exception);
    }
}