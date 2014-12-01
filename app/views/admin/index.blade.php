<div class="row">
	<div class="col-md-10  col-md-offset-1">
		<div class="col-md-12">
			<div class='col-md-6 admin-dash-welcome'>
				<h1>ADMIN VIEW</h1>
			</div>
			<div class='col-md-6 admin-dash-profile'>
				<dl class='dl-horizontal'>
					<dt>USER</dt> 		<dd>{{ $user_count }}</dd>
					<dt>SERIES</dt>		<dd>{{ $books_count }} </dd>
					<dt>ISSUES</dt>		<dd>{{ $issue_count }}</dd>
					<dt>PUBLISHERS</dt> 	<dd>{{ $publisher_count }}</dd>
					<dt>AUTHORS</dt>		<dd>{{ $author_count }} </dd>
					<dt>ARTISTS</dt>		<dd>{{ $artist_count }} </dd>
				</dl>
			</div>
		</div>
	</div>
	<div class="col-md-10  col-md-offset-1">
		<div class="col-md-12 table-responsive">
			<h1 class="jumbotron">ALL USERS </h1>
			<table class='table'>
				<thead>
					<tr>
						<th>USERNAME</th>
						<th>EMAIL</th>
						<th>USER ROLE</th>
						<th>ACTIVE STATUS</th>
						<th></th>
					</tr>
				</thead>
				@foreach($users as $user) 
					<tr>
						<td>{{ $user->username 	}}</td>
						<td>{{ $user->email 	}}</td>
						<td>
							@if($user->admin) 
								ADMIN
							@else 
								USER
							@endif
						</td>
						<td>
							@if($user->active) 
								ACTIVE
							@else 
								INACTIVE
							@endif
						</td>
						<td>
							@if(!$user->admin) 
								{{ Form::open(array('method' => 'delete', 'route' => array('users.destroy', $user->id))) }}
								 	{{ Form::hidden('_method', 'DELETE') }}
									{{ Form::submit('Delete', array('class'=>'btn btn-large btn-warning', 'id'=>'deleteUser')) }}
								{{ Form::close() }}
							@endif
						</td>
					</tr>
				@endforeach
			</table>
			<div>{{ $users->links() }}</div>
		</div>
	</div>
	<div class="col-md-10  col-md-offset-1">
		<div class="col-md-12 table-responsive">
			<h1 class="jumbotron">MOST RECENTLY UPDATED BOOKS</h1>
			<table class='table'>
				<thead>
					<tr>
						<th>BOOK NAME</th>
						<th>UPDATED AT</th>
					</tr>
				</thead>
				@foreach($recent_books as $book) 
					<tr>
						<td>{{ Str::upper($book->book_name) }}</td>
						<td>{{ date_format($book->updated_at, "M d, Y") }}</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
	<div class="col-md-10  col-md-offset-1">
		<div class="col-md-12 table-responsive">
			<h1 class="jumbotron">UPLOAD ACTIVITY</h1>
			<canvas id="admin-stats" width='800px' height='300px'></canvas>
		</div>
	</div>
</div>

{{ HTML::script('js/Chart.js-master/Chart.min.js') }}
<script>
	$(function () {
		$('#deleteUser').click(function(){
			alert("Are you sure you want to delete this user?");
		})
	});
	var ctxUpload = $('#admin-stats').get(0).getContext("2d");
    var dataUpload = {
        labels: {{ $created_issues_date }},
	    datasets: [
	        { 
	        	label: "Books Uploaded",
	            fillColor: "rgba(220,220,220,0.2)",
	            strokeColor: "rgba(220,220,220,1)",
	            pointColor: "rgba(220,220,220,1)",
	            pointStrokeColor: "#fff",
	            pointHighlightFill: "#fff",
	            pointHighlightStroke: "rgba(220,220,220,1)",
	            data: {{ $created_books }}
	        },
	        { 
	        	label: "Issues Uploaded",
	            fillColor: "rgba(151,187,205,0.2)",
	            strokeColor: "rgba(151,187,205,1)",
	            pointColor: "rgba(151,187,205,1)",
	            pointStrokeColor: "#fff",
	            pointHighlightFill: "#fff",
	            pointHighlightStroke: "rgba(151,187,205,1)",
	            data: {{ $created_issues }}
	        }, 
	    ]
    };
    var readUploadChart = new Chart(ctxUpload).Line(dataUpload, {
    	legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

    });
</script>