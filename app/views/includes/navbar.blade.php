<nav class="navbar navbar-fixed-top navbar-collapse bg-primary" id="top-nav" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">   
            @if(!Auth::check())
                <p class="navbar-text navbar-right">{{ HTML::link('register', 'REGISTER') }}</p>
                <p class="navbar-text navbar-right">{{ HTML::link('login', 'LOGIN') }}</p>
            @else
                <p class="navbar-text navbar-left">{{ HTML::link('logout', 'LOGOUT') }}</p> 
                <p class="navbar-text navbar-right">signed in as {{ Auth::user()->username; }}</p>
            @endif
        </div>
    </div>
</nav>