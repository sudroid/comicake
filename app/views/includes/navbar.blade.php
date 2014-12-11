<ul class="nav nav-pills" id="top-nav" role="navigation">

    <li role="presentation" ><a href="" class="toggle-panel"><span class="glyphicon glyphicon-align-justify"></span></a></li>
    @if(!Auth::check())
        <li role="presentation" >{{ HTML::link('register', 'REGISTER') }}</li>
        <li role="presentation" >{{ HTML::link('login', 'LOGIN') }}</li>
    @else
        <li role="presentation" ><a href="/dashboard"><span class="glyphicon glyphicon-user"></span></a></li>
        <li role="presentation" >{{ HTML::link('logout', 'LOGOUT ( '. Auth::user()->username .')') }} </li> 
    @endif
</ul>