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
				<dt>JOINED DATE:</dt>		<dd>{{ Str::upper(date_format(Auth::user()->created_at, "M d, Y")) }}</dd>
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
		<div class='col-md-6 read-list'>
			<h3>READ BY PUBLISHER </h3>
			<canvas id="user-stats-publisher" width='500px' height='250px'></canvas>
		</div>
		<div class='col-md-6 read-list'>
			<h3>READ BY GENRE </h3>
			<canvas id="user-stats-genre" width='500px' height='250px'></canvas>
		</div>
	</div>
	<div class='col-md-10 col-md-offset-1'>
		<p>Leaving us? Click <a href="#" id="deactivate">here</a> to deactivate your account.</p>
	</div>
</div>
<div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog" aria-labelledby="deactivateModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="deactivateModalLabel">Are you sure you want to leave us?</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(array('url' => 'deactivate', 'method' => 'post')) }}
				 	{{ Form::label('Please confirm by clicking deactivate. :(')}}
					{{ Form::submit('Deactivate', array('class'=>'btn btn-large btn-warning pull-right')) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

{{ HTML::script('js/Chart.js-master/Chart.min.js') }}
<script>
	var ctxGenre = $('#user-stats-genre').get(0).getContext("2d");
    var dataGenre = {
        labels: {{ $read_genre_name }},
	    datasets: [
	        { 
	            fillColor: "rgba(220,220,220,0.2)",
	            strokeColor: "rgba(220,220,220,1)",
	            pointColor: "rgba(220,220,220,1)",
	            pointStrokeColor: "#fff",
	            pointHighlightFill: "#fff",
	            pointHighlightStroke: "rgba(220,220,220,1)",
	            data: {{ $read_genre_count }}
	        } 
	    ]
    };
    var readGenreChart = new Chart(ctxGenre).Radar(dataGenre);

  	var ctxPublisher = $('#user-stats-publisher').get(0).getContext("2d");
    var dataPublisher = {
        labels: {{ $read_publisher_name }},
	    datasets: [
	        {
	            fillColor: "rgba(220,220,220,0.2)",
	            strokeColor: "rgba(220,220,220,1)",
	            pointColor: "rgba(220,220,220,1)",
	            pointStrokeColor: "#fff",
	            pointHighlightFill: "#fff",
	            pointHighlightStroke: "rgba(220,220,220,1)",
	            data: {{ $read_publisher_count }}
	        } 
	    ]
    };
    var readPublisherChart = new Chart(ctxPublisher).Radar(dataPublisher);

    
</script>