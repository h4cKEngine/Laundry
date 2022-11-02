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
    public function tokenCheck(Request $request)
    {
        try{
            $tokenable = PersonalAccessToken::find($request->bearerToken()); //record della tabella personal access
            if($tokenable->tokenable->ruolo == 1){ //Controllo se l'utente è un Admin
                return $request;
            }
            return response()->json(["Errore" => 'Permessi insufficienti.'], 403);
            
        }catch(\Exception $e){
            throw new PermissionException();
        }
    }

    public function handle(Request $request, Closure $next, User $user)
    {
    }
}
