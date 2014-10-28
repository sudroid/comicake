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
		<div class="col-md-6 table-responsive">
			<h1 class="jumbotron">ALL ACTIVE USERS </h1>
			<table class='table'>
				<thead>
					<tr>
						<th>USERNAME</th>
						<th>EMAIL</th>
					</tr>
				</thead>
				@foreach($users_active as $user) 
					<tr>
						<td>{{ $user->username 	}}</td>
						<td>{{ $user->email 	}}</td>
					</tr>
				@endforeach
			</table>
		</div>
		<div class="col-md-6 table-responsive">
			<h1 class="jumbotron">ALL INACTIVE USERS</h1>
			<table class='table'>
				<thead>
					<tr>
						<th>USERNAME</th>
						<th>EMAIL</th>
					</tr>
				</thead>
				@foreach($users_inactive as $user) 
					<tr>
						<td>{{ $user->username 	}}</td>
						<td>{{ $user->email 	}}</td>
					</tr>
				@endforeach
			</table>
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
		</div>
	</div>
</div>
