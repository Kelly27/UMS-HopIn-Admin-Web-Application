<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class CORS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // header('Access-Control-Allow-Origin: http://localhost:8080'); //for ios, update: useless, just use the webview thing
        header('Access-Control-Allow-Origin: *');

        $IlluminateResponse = 'Illuminate\Http\Response';
        $SymfonyResopnse = 'Symfony\Component\HttpFoundation\Response';

        $headers = [
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin',
        ];

        if($request->getMethod() == "OPTIONS"){
            return Response::make('OK', 200, $headers);
        }

        $response = $next($request);

        if($response instanceof $IlluminateResponse) {
            foreach ($headers as $key => $value) {
                $response->header($key, $value);
            }
            return $response;
        }

        if($response instanceof $SymfonyResopnse) {
            foreach ($headers as $key => $value) {
                $response->headers->set($key, $value);
            }
            return $response;
        }

        return $response;
    }
}
