<div class="row">
	<div class="col-md-3">
		@include('layouts.sidebar')
	</div>
	<div class="col-md-9 pull-right">
		<h1 class="text-uppercase">{{ HTML::link('browse/series/'.$book_title, $book_title) }}</h1>
		<br />
		@foreach($book_info as $info)
			<div class="col-md-4 pull-left">
				{{ HTML::image($info->cover_image, $info->issue_id . $info->book_id, array('width' => '100%')); }}
			</div>
			<div class="col-md-8 pull-right text-uppercase text-left">
				<dl class="dl-horizontal">				
					<dt>Writer:</dt> <dd> {{ HTML::link('browse/authors/'.$info->author_name , $info->author_name ) }}</dd>
					<dt>Artist:</dt> <dd> {{ HTML::link('browse/artists/'.$info->artist_name, $info->artist_name ) }}</dd>
					<dt>Genre:</dt> 
						@foreach($book_genre as $genre)
							<dd>{{ HTML::link('browse/genre/'.$genre->genre_name, $genre->genre_name ) }}</dd>
						@endforeach
					<dt>Publisher:</dt> <dd> {{ HTML::link('browse/publishers/'.$info->publisher_name, $info->publisher_name ) }}</dd>
					<dt>Published Date:</dt> <dd> {{ $info->published_date }}</dd>
					<dt>Description:</dt> <dd>{{ $info->summary }}</dd>
					<dt>Characters:</dt> 
						@foreach($book_characters as $character)
							<dd>{{ HTML::link('browse/characters/'.$character->character_name, $character->character_name ) }}</dd>
						@endforeach
				</dl>
			</div>
		@endforeach
		@if(Auth::check())
			<div class="col-md-4 pull-right">
				{{ HTML::link('edit/issues/'.$book_title.'/'.$book_issue, 'EDIT SERIES INFORMATION', array('class'=>'btn btn-primary btn-block'))}}
				{{ HTML::link(URL::previous(), 'BACK', array('class'=>'btn btn-primary btn-block'))}}
			</div>
		@else
			<div class="col-md-4 pull-right">
				{{ HTML::link(URL::previous(), 'BACK', array('class'=>'btn btn-primary btn-block'))}}
			</div>
		@endif
	</div>
</div>