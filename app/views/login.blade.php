{{ Form::open(array('url'=>'signin', 'class'=>'form-signin')) }}
	<h2 class="form-signin-heading">Login</h2>

	{{ Form::text('username', null, array('class'=>'control-label col-sm-12 form-control', 'placeholder'=>'Username')) }}
	{{ Form::password('password', array('class'=>'control-label col-sm-12 form-control', 'placeholder'=>'Password')) }}

	{{ Form::submit('Login', array('class'=>'btn btn-large btn-warning btn-block'))}}
{{ Form::close() }}
{{ HTML::link('password/remind', 'FORGOT YOUR PASSWORD?') }}