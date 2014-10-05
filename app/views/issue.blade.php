<div class="row">
	<div class="col-md-3">
		@include('layouts.sidebar')
	</div>
	<div class="col-md-9 pull-right">
		<h1 class="text-uppercase">{{ $book_title }}</h1>
		<br />
		@foreach($book_info as $info)
			<div class="col-md-6 pull-left">
				{{ HTML::image($info->cover_image, $info->issue_id . $info->book_id, array('width' => '100%')); }}
			</div>
			<div class="col-md-6 pull-right text-uppercase text-left">
				<dl class="dl-horizontal">				
					<dt>Writer:<dt> <dd> {{ HTML::link('browse/authors/'.$info->author_name , $info->author_name ) }}</dd>
					<dt>Artist:<dt> <dd> {{ HTML::link('browse/artists/'.$info->artist_name, $info->artist_name ) }}</dd>
					<dt>Genre:<dt> <dd> {{ HTML::link('browse/genre/'.$info->genre_name, $info->genre_name ) }}</dd>
					<dt>Publisher:<dt> <dd> {{ HTML::link('browse/publisher/'.$info->publisher_name, $info->publisher_name ) }}</dd>
					<dt>Description:<dt> <dd>{{ $info->book_description }}</dd>
				</dl>
			</div>
		@endforeach
	</div>
</div>