<nav class="navbar navbar-fixed-top navbar-collapse bg-primary" id="top-nav" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">   
            <p class="navbar-text navbar-left"><a href="" class="toggle-panel"><span class="glyphicon glyphicon-align-justify"></span></a></p>
        </div>
        <div>
            @if(!Auth::check())
                <p class="navbar-text navbar-left">{{ HTML::link('register', 'REGISTER') }}</p>
                <p class="navbar-text navbar-left">{{ HTML::link('login', 'LOGIN') }}</p>
            @else
                <p class="navbar-text navbar-left"><a href="/dashboard"><span class="glyphicon glyphicon-user"></span></p>
                <p class="navbar-text navbar-left">{{ HTML::link('logout', 'LOGOUT') }} ( {{ Auth::user()->username; }})</p> 
            @endif
        </div>
    </div>
</nav>