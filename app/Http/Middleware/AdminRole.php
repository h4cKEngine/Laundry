<?php

namespace App\Http\Middleware;

use App\Exceptions\PermissionDenyException;
use App\Exceptions\PermissionException;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AdminRole
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
        if(!$request->bearerToken()) // Token inesistente
            throw new PermissionDenyException();
    
        // Acquisisce il token
        $token = PersonalAccessToken::find($request->bearerToken());
        // 0 per user, 1 per Admin
        if($token->tokenable->ruolo){
            return $next($request); // Risposta dell'api
        }
        throw new PermissionException();
    }
}
