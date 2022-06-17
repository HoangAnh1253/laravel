<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

use function PHPUnit\Framework\isNull;

class Authorize
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

        $user = Auth::user();
        if (is_null($user)) {
            return new Response([
                "message" => "You are not login"
            ], HttpFoundationResponse::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }
        if (!$user->is_admin) {
            return new Response([
                "message" => "You are not authorize"
            ], HttpFoundationResponse::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }
        return $next($request);
    }
}