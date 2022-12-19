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
            'email' => 'required|string|email|max:255|unique:users',
            'matricola' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'nazionalita' => 'string',
        ], [
            'string' => 'Errore inserire string',
            'unique' => 'Errore campo esistente',
            'required' => 'Errore, inserire un campo'
        ]);

        // Query di controllo del primo record dalla tabella users attraverso email e matricola. firstOrFail() selezione del primo record oppure errore
        // $email =User::select('email')->from('users')->where('email', $request['email'])->first();
        // $matricola =User::select('matricola')->from('users')->where('matricola', $request['matricola'])->first();

        // Query di creazione
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
    {   
        // Il metodo attempt() accetta un array associativo come primo argomento. Il valore della password verrà sottoposto a hash. 
        // Gli altri valori nell'array verranno utilizzati per trovare l'utente nella tabella del database.
        // if ( !) )
        //     return response()->json(['access' => False, 'message' => 'Informazioni di Login errate'], 401);
    
        
        // Restituzione di un json come risposta tramite codice HTTP di conferma (200)
        // response()->json([
        //     'access' => True,
        //     'access_token' => $token,
        //     'token_type' => 'Bearer',
        //     // I Bearer Token sono un tipo particolare di Access Token, che utilizzano JWT:

        //     /*Ogni JSON Web Token è suddiviso in tre parti e ogni parte è separata da un punto ( xxxxx.yyyyy.zzzzz ):
        //         - Header: contiene informazioni sul tipo di token JWT e sull’algoritmo di hashing utilizzato, ad esempio HMAC SHA256 o RSA.
        //         - Payload: contiene tutte le informazioni che si desidera trasferire all’utente, ad esempio l’identificatore utente.
        //         - Signature: protegge il token ed è un hash dell’intestazione e del payload codificati, insieme a una chiave.*/
            
        //     // usati per ottenere l'autorizzazione ad accedere ad una risorsa protetta da un Authorization Server
        // ], 200); 

        $authentication = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if(!$authentication)
            return redirect()->back()->withErrors([
                'status' => 'error',
                'message' => 'Credenziali errate.',
            ]); // Error 401

        // Rigenerazione della sessione per prevenire il session fixation
        $request->session()->regenerate();
        
        // Query di selezione per il controllo della prima occorrenza record dalla tabella users attraverso email. 
        $user = User::where('email', $request['email'])->firstOrFail(); // firstOrFail() selezione del primo record oppure errore
        
        // Generazione del token
        if ($user){
            $token = $user->createToken($user->email)->plainTextToken;

            return response()->json([
                'status' => 'ok',
                'message' => 'Login effettuato con successo',
                'bearer_token' => $token // Creazione Bearer Token
            ]);
        }
     
        // Reindirizzamento in base al ruolo
        // switch (auth()->user()->ruolo) {
        //     case 0:
        //         return redirect("/user");
        //     case 1:
        //         return redirect("/admin");
        //     default:
        //         return redirect("/login");
        // }
    }
    
    // Funzione di logout e rimozione token
    public function logout(Request $request)
    {    
        // Ottiene il token dalla request
        //$accessToken = $request->bearerToken();

        // Ottiene il token dal cookie
        $accessToken = $_COOKIE['bearer_token'];

        // Ottiene il token dal db
        $token = PersonalAccessToken::findToken($accessToken);
        // Rimuove il token
        $token->delete();

        // Rigenerazione Sessione
        $request->session()->regenerate();
        // Logout
        Auth::logout();

        return redirect('/');
    }
}