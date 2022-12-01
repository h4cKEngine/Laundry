<nav id="navbar">    
    <div id="nav-sx">
        <a id="hello-message">
            Welcome UserName
        </a>
    </div>
    <div id="nav-middle">    
        <a href="./" id="icona">
            <img  src="/img/laundryLogo.png">
        </a>
    </div>
    <div id="nav-dx">
        @auth
            @if (Auth::user()->ruolo == 0)
                <a href="./user">Account</a>
                <a href="./logout">Logout</a>
            @elseif (Auth::user()->ruolo == 1)
                <a href="./admin">Account</a>
                <a href="./logout">Logout</a>
            @endif
        @else
            <a href="./signup">Signup</a>
            <a href="./login">Login</a>
        @endauth 
    </div>
</nav>