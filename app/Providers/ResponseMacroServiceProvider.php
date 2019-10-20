<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{

    /**
     * Register the application's response macros.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro(
            'jsonResult',
            function (bool $status, $errors, $data, int $code = \Illuminate\Http\Response::HTTP_OK, string $message = '')
            {
                $headers = ['Content-Type' => 'application/json; charset=utf-8'];
                return response()->json([
                    'status' => $status,
                    'data' => $data,
                    'errors' => $errors
                ], $code, $headers, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
            });
    }

}
