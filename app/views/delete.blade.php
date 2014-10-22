<p>Are you sure you want to delete {{ $book_name }}?</p>
 
{{ Form::open([array('url' => 'content/' . $book_id, 'method' => 'delete']) }}
 	{{ Form::hidden('_method', 'DELETE') }}
	{{ Form::submit('Delete this series', array('class'=>'btn btn-large btn-warning pull-right')) }}
{{ Form::close() }}