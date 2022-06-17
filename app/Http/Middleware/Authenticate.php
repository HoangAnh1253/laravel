<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;




class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }


    // public function handle($request, Closure $next, ...$guards)
    // {
    //     if ($jwt = $request->cookie('jwt'))
    //         $request->headers->set('Authorization', 'Bearer ' . $jwt);
    //     $this->authenticate($request, $guards);
    //     $user = Auth::user();
    //     if (is_null($user)) {
    //         return new Response([
    //             "message" => "You are not login"
    //         ], HttpFoundationResponse::HTTP_NON_AUTHORITATIVE_INFORMATION);
    //     }
    //     return $next($request);
    // }
}