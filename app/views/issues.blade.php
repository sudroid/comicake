<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-11 pull-left">
		<h1 class="text-uppercase">{{ HTML::link('browse/series/'.$book_title, $book_title) }}</h1>
		{{Session::put('book_title', $book_title);}}
		<br />
		@foreach($book_info as $info)
			<div class="col-md-4 pull-left">
				{{ HTML::image($info->cover_image, $info->issue_id . $info->book_id, array('width' => '100%')); }}
			</div>
			<div class="col-md-8 pull-right text-uppercase text-left">
				<dl class="dl-horizontal">				
					<dt>Writer:</dt> <dd> {{ HTML::link('browse/authors/'.$info->author_name , $info->author_name ) }}</dd>
					<dt>Artist:</dt> <dd> {{ HTML::link('browse/artists/'.$info->artist_name, $info->artist_name ) }}</dd>
					<dt>Published Date:</dt> <dd> {{ $info->published_date }}</dd>
					<dt>Issue Summary:</dt> <dd>{{ $info->summary }}</dd>
				</dl>
			</div>
		
		@if(Auth::check())
			<div class="col-md-4 pull-right">
				{{ HTML::link('content/issue/'.$info->issue_id.'/edit', 'EDIT ISSUE INFORMATION', array('class'=>'btn btn-primary btn-block'))}}
				@if(Auth::user()->admin) 
					{{ HTML::link('#', 'DELETE ISSUE', array('class'=>'btn btn-primary btn-block','id'=>'delete'))}}
				@endif
				{{ HTML::link(URL::previous(), 'BACK', array('class'=>'btn btn-primary btn-block'))}}
			</div>
		@else
			<div class="col-md-4 pull-right">
				{{ HTML::link(URL::previous(), 'BACK', array('class'=>'btn btn-primary btn-block'))}}
			</div>
		@endif
		@endforeach
	</div>
</div>
@if(Auth::check())
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="deleteModalLabel">Are you sure you want to delete this issue</em>?</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(array('url' => 'content/issue/' . $book_info[0]->issue_id, 'method' => 'delete')) }}
				 	{{ Form::hidden('_method', 'DELETE') }}
				 	{{ Form::label('This is only for admins.')}}
					{{ Form::submit('Delete this issue', array('class'=>'btn btn-large btn-warning pull-right')) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@endif