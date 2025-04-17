<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
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

    protected $messages = [
        // 302 => 'Geçici Yönlendime (Temporary Redirect)',
        400 => 'Kötü İstek (Bad Request)',
        401 => 'Yetkisiz (Unauthorized)',
        403 => 'Yasak (Forbidden)',
        404 => 'Bulunamadı (NotFound)',
        405 => 'Yanlış HTTP Metodu (Method Not Allowed)',

        500 => 'Sunucu Hatası (Internal Server Error)',
        502 => 'Geçersiz Ağ Geçidi (Bad Gateway',
        503 => 'Hizmet Yok',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

        });
    }

    /**
 * Prepare exception for rendering.
 *
 * @param  \Throwable  $e
 * @return \Throwable
 */
    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);

        $status = $response->getStatusCode();

        // activity()
        // ->causedBy(auth()->id())
        // ->event('exception')
        // ->withProperties([
        //     'message' => $this->messages[$status],
        //     'error' => $e,
        // ])
        // ->log('exception');


        if (app()->environment(['local', 'testing'])) {
            return $response;
        } elseif ($status === 419) {
            return back()->with([
                'message' => 'Sayfa zamanaşımına uğradı. Lütfen tekrar giriş yapınız',
            ]);
        }

        if (! array_key_exists($status, $this->messages)) {
            return $response;
        }

        if (! $request->isMethod('GET')) {
            return back()
                ->setStatusCode($status)
                ->with('error', $this->messages[$status]);
        }

        // return inertia('Error', [
        //     'status' => $status,
        //     'message' => $this->messages[$status],
        // ])
        //     ->toResponse($request)
        //     ->setStatusCode($status);
        return $response;

    }


}
