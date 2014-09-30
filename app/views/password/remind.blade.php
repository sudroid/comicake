<h2>Password Reset</h2>

<div>
	@if (Session::has('error'))
		<p>{{ Session::get('error') }}</p>
	@elseif (Session::has('status'))
		<p>{{ Session::get('status') }}</p>
	@endif
	{{ Form::open(array('url'=>'password/remind', 'class'=>'form-signin')) }}
		{{ Form::email('email', null, array('class'=>'control-label col-sm-12 form-control', 'placeholder'=>'Email')) }}
		{{ Form::submit('Send Reminder', array('class'=>'btn btn-large btn-warning btn-block'))}}
	{{ Form::close() }}
</div>