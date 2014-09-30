{{ Form::open(array('url'=>'create', 'class'=>'form-signup')) }}
    <h2 class="form-signup-heading">Please Register</h2>
 
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
 
    {{ Form::text('username', null, array('class'=>'control-label col-sm-12 form-control', 'placeholder'=>'Username')) }}
    {{ Form::email('email', null, array('class'=>'control-label col-sm-12 form-control', 'placeholder'=>'Email Address')) }}
    {{ Form::password('password', array('class'=>'control-label col-sm-12 form-control', 'placeholder'=>'Password')) }}
    {{ Form::password('password_confirmation', array('class'=>'control-label col-sm-12 form-control', 'placeholder'=>'Confirm Password')) }} 
    {{ Form::submit('Register', array('class'=>'btn btn-large btn-warning btn-block'))}}
{{ Form::close() }}