<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-11 pull-left">
		<h1 class="text-uppercase">{{ $book_title }}</h1>
		{{Session::put('book_title', $book_title);}}
		<br />
		<div class="col-md-8 pull-left text-uppercase text-left">
			<dl class="dl-horizontal">	
				<dt>Genre:<dt> 
					@foreach($book_genre as $genre)
						<dd>{{ HTML::link('browse/genre/'.$genre->genre_name, $genre->genre_name ) }}</dd>
					@endforeach
				<dt>Publisher:<dt> <dd> {{ HTML::link('browse/publishers/'.$book_info[0]->publisher_name, $book_info[0]->publisher_name ) }}</dd>
				<dt>SERIES SUMMARY:<dt> <dd>{{ $book_info[0]->book_description }}</dd>
				<dt>Characters:</dt> 
					@foreach($book_characters as $character)
						<dd>{{ HTML::link('browse/characters/'.$character->character_name, $character->character_name ) }}</dd>
					@endforeach
			</dl>
		</div>
		@if(Auth::check())
			<div class="col-md-3 pull-left text-uppercase text-left links_list">
					{{ HTML::link('content/series/'.$book_title.'/edit', 'EDIT SERIES INFORMATION', array('class'=>'btn btn-primary btn-block'))}}
					{{ HTML::link('content/issue/create', 'ADD NEW ISSUE', array('class'=>'btn btn-primary btn-block'))}}
					{{ HTML::link('#', 'DELETE SERIES', array('class'=>'btn btn-primary btn-block', 'id'=>'delete'))}}
					{{ HTML::link(URL::previous(), 'BACK', array('class'=>'btn btn-primary btn-block'))}}
			</div>
		@else
			<div class="col-md-3 pull-left text-uppercase text-left links_list">
				{{ HTML::link(URL::previous(), 'BACK', array('class'=>'btn btn-primary btn-block'))}}
			</div>
		@endif
		<div class="col-md-8">
			@if(isset($book_issues))
				@foreach($book_issues as $issue)
					<div class="col-md-3 pull-left thumbnail">
						<a href='{{ $book_title }}/{{ $issue->issue_id }}' >{{ HTML::image($issue->cover_image, $book_title . $issue->issue_id, array('width' => '100%', 'class'=>'img-rounded')); }}</a>
					</div>
				@endforeach
			@endif
		</div>
	</div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="deleteModalLabel">Are you sure you want to delete <em>{{ strtoupper($book_title) }}</em>?</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(array('url' => 'content/series/' . $book_title, 'method' => 'delete')) }}
				 	{{ Form::hidden('_method', 'DELETE') }}
				 	{{ Form::label('This is only for admins.')}}
					{{ Form::submit('Delete this series', array('class'=>'btn btn-large btn-warning pull-right')) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>