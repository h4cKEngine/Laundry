<nav id="navbar">    
    <div id="nav-sx">
    @auth
        @if (Auth::user()->ruolo == 0 || Auth::user()->ruolo == 1)
            <a id="hello-message">Welcome {{auth()->user()->nome}}</a>
        @endif
    @else
        <a id="hello-message">Laundry</a>
    @endauth 
    
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