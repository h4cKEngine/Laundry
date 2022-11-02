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
    public function handle(Request $request, Closure $next, User $user)
    {
        try{
            $tokenable = PersonalAccessToken::find(request()->bearerToken()); //record della tabella personal access
            if($tokenable->tokenable->ruolo == 1){ //Admin
                // $auth = new AuthController;
                // $auth->login($request);
                return json_encode(["Admin" => "confermato"]);
            }
            
        }catch(\Exception $e){
            throw new PermissionException();
        }
    }
}
