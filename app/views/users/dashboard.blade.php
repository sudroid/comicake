<div class='row'>
	<div class='col-md-10 col-md-offset-1'>
		<div class='col-md-6 dash-welcome'>
			<h1>DASHBOARD</h1>
			<h4>Welcome back, {{ Str::upper(Auth::user()->username) }}!</h4>
		</div> 
		<div class='col-md-6 dash-profile'>
			<dl  class="dl-horizontal text-left">
				<dt>USERNAME:</dt> 			<dd>{{ Str::upper(Auth::user()->username) }}</dd>
				<dt>REGISTERED EMAIL:</dt>	<dd>{{ Str::upper(Auth::user()->email) }}</dd>
				<dt>USER STATUS:</dt>		<dd>{{ $active_msg }}</dd>
				<dt>USER PERMISSIONS:</dt>	<dd>{{ HTML::link(Str::lower($admin_msg), $admin_msg) }}</dd>
				<dt>CREATED DATE:</dt>		<dd>{{ Str::upper(date_format(Auth::user()->created_at, "M d, Y")) }}</dd>
			</dl>
		</div>
	</div>
	<div class='col-md-10 col-md-offset-1'>
		<div class='col-md-6 read-list'>
			<h3>HAVE READ:</h3>
			<ul>
				@foreach($user_read as $read)
					<li>{{ HTML::link('browse/series/'.$read->book_name, $read->book_name) }}</li>
				@endforeach
			</ul>
		</div>
		<div class='col-md-6 reading-list'>
			<h3>TO READ:</h3>
			<ul>
				@foreach($user_to_read as $reading)
					<li>{{ HTML::link('browse/series/'.$reading->book_name, $reading->book_name) }}</li>
				@endforeach
			</ul>
		</div>
	</div>
	<div class='col-md-10 col-md-offset-1'>
		<p>Leaving us? Click here to deactivate your account.</p>
	</div>
</div>