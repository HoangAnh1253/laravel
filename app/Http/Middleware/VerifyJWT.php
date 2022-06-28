<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class VerifyJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($jwt = $request->cookie('jwt'))
                $request->headers->set('Authorization', 'Bearer ' . $jwt);
        try{
            $user = JWTAuth::parseToken()->authenticate();
        }catch(Exception $e){
            return new Response(["Message" => $e->getMessage()], HttpFoundationResponse::HTTP_UNAUTHORIZED);
        }
        if(!$user->is_admin){
            return new Response(["Message" => "You are not authorize"], HttpFoundationResponse::HTTP_UNAUTHORIZED);
        }
        error_log($user);
        return $next($request);
    }
}