<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{  
    // Funzione di registrazione e query di creazione
    public function register(Request $request)
    {  
        // Controllo validazione campi da inserire nella query
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:users', // Query di controllo del primo record dalla tabella users attraverso email e matricola
            'matricola' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'nazionalita' => 'string',
        ], [
            'string' => 'Errore inserire string',
            'unique' => 'Errore valore già esistente',
            'required' => 'Errore, inserire un campo'
        ]);

        // Query di creazione utente nella tabella users
        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Utilizzo di una password cifrata tramite algoritmo di hash Bcrypt
            'nome' => $validatedData['nome'],
            'cognome' => $validatedData['cognome'],
            'matricola' => $validatedData['matricola'],
            'nazionalita' => $validatedData['nazionalita']
        ]);

        // Accesso automatico, subito dopo aver creato account
        $this->login($request);
    }

    // Funzione di login e query ricerca
    public function login(Request $request)
    {   // Il metodo attempt() accetta un array associativo come primo argomento. Il valore della password verrà sottoposto a hash
        // Gli altri valori nell'array verranno utilizzati per trovare l'utente nella tabella del database
        $authentication = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);
        
        if(!$authentication)
            return redirect()->back()->withErrors([
                'status' => 'error 401',
                'message' => 'Credenziali errate.',
            ]); // Status code 401
        
        // Rigenerazione della sessione per prevenire il session fixation
        $request->session()->regenerate();
        
        // Query di selezione per il controllo della prima occorrenza record dalla tabella users attraverso email. 
        $user = User::where('email', $request['email'])->firstOrFail(); // firstOrFail() selezione del primo record oppure errore
        
        // Generazione del Bearer token
        if ($user){
            $token = $user->createToken($user->email)->plainTextToken;
            
            // I Bearer Token sono un tipo particolare di Access Token, che utilizzano JWT:
    
                /*Ogni JSON Web Token è suddiviso in tre parti e ogni parte è separata da un punto ( xxxxx.yyyyy.zzzzz ):
                    - Header: contiene informazioni sul tipo di token JWT e sull’algoritmo di hashing utilizzato, ad esempio HMAC SHA256 o RSA.
                    - Payload: contiene tutte le informazioni che si desidera trasferire all’utente, ad esempio l’identificatore utente.
                    - Signature: protegge il token ed è un hash dell’intestazione e del payload codificati, insieme a una chiave.*/
                
            // utilizzati per ottenere l'autorizzazione ad accedere ad una risorsa protetta
            return response()->json([
                'status' => 'ok 200', // Status code 200
                'message' => 'Login effettuato con successo',
                'bearer_token' => $token // Creazione Bearer Token
            ]);
        }
    }
    
    // Funzione di logout e rimozione token
    public function logout(Request $request)
    {    
        // Ottiene il token dalla request
        //$accessToken = $request->bearerToken();

        // Ottiene il token dal cookie
        $accessToken = $_COOKIE['bearer_token'];
        // Rimuove il token
        Auth::user()->tokens()->delete(); // Errore è normale in quanto VS code non riesce a trovare corrispondenza

        // Rigenerazione Sessione
        $request->session()->regenerate();
        // Logout
        Auth::logout();

        return redirect('/');
    }
}