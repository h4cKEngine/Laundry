<nav id="navbar">    
    <div id="nav-sx">
        <a id="hello-message">
            Vai
            {{-- Welcome {{auth()->user()->nome}}  --}}
        </a>
    </div>
    <div id="nav-middle">    
        <a href="./" id="icona">
            <img  src="/img/laundryLogo.png">
        </a>
    </div>
    <div id="nav-dx">
        {{-- {{ dd(Auth::user()) }} --}}
    @auth
        @if (Auth::user()->ruolo == 0)
            <a href="/user">Account</a>
        @elseif (Auth::user()->ruolo == 1)
            <a href="/admin">Admin Account</a>
        @endif
        <a href="/auth/logout">Logout</a>
    @else
        <a href="/signup">Signup</a>
        <a href="/login">Login</a>
    @endauth 
    </div>
</nav>