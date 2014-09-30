@if (Session::has('error'))
	<p>{{ Session::get('error') }}</p>
@elseif (Session::has('status'))
	<p>{{ Session::get('status') }}</p>
@endif
{{ Form::open(array('url'=>'password/reset', 'class'=>'form-signin')) }}
	{{ Form::hidden('token', $token) }}
	{{ Form::email('email', null, array('class'=>'control-label col-sm-12 form-control', 'placeholder'=>'Email Address')) }}
    {{ Form::password('password', array('class'=>'control-label col-sm-12 form-control', 'placeholder'=>'Password')) }}
    {{ Form::password('password_confirmation', array('class'=>'control-label col-sm-12 form-control', 'placeholder'=>'Confirm Password')) }}
	{{ Form::submit('RESET', array('class'=>'btn btn-large btn-warning btn-block'))}}
{{ Form::close() }}