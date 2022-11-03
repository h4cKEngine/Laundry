<?php

namespace App\Http\Middleware;

use App\Exceptions\PermissionException;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Laravel\Sanctum\PersonalAccessToken;

class Role
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
        // 0 per user 1 per Admin
        $token = PersonalAccessToken::find($request->bearerToken());

        if($this->token || $token->tokenable->id == $request->route()->parameter('user')->id){
            return $next($request); // Risposta dell'api
        }
        throw new PermissionException();
    }
}
