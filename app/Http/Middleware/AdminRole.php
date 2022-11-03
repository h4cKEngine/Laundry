<?php

namespace App\Http\Middleware;

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
        return response()->json(["error"=>'Non autenticato.'], 403); // Error 403 Unathorized
    
        // Acquisisce il token
        $token = PersonalAccessToken::find($request->bearerToken());
        // 0 per user 1 per Admin
        if($token->tokenable->ruolo === 1){
            return $next($request); // Risposta dell'api
        }
        throw new PermissionException();
    }
}
