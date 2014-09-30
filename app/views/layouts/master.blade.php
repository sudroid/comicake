<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>C O M I C A K E</title>
	{{ HTML::script('js/jquery-2.1.1.min.js') }}
	{{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/ryun-HCaptions/jquery.hcaptions.js') }}
    {{ HTML::script('js/script.js') }}
	{{ HTML::style('css/bootstrap.css') }}
    {{ HTML::style('css/style.css') }}
<style>
    body {
        padding-top: 130px;
    }
     
    .form-signup, .form-signin {
        width: 300px;
        margin: 0 auto;
    }
</style>
<script>
    $(window).load(function(){
        $('.hcaption').hcaptions({
            effect: "fade"
        });
    });
</script>
<body>
    @if(Request::path() != '/')
    <nav class="navbar navbar-fixed-top collapse navbar-collapse" id="top-nav" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">   
                @if(!Auth::check())
                    {{ HTML::link('register', 'REGISTER') }}  
                    {{ HTML::link('login', 'LOGIN') }}   
                @else
                    {{ HTML::link('logout', 'LOGOUT') }} ( {{ Auth::user()->username; }} )
                @endif
            </div>
        </div><!-- end nav -->
	</nav>
    @endif
    <div class="container">
    @if(Session::has('message'))
        <p class="alert">{{ Session::get('message') }}</p>
    @endif
    {{ $content }}
    </div>
</body>
</html>
