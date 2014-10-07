<div class="row">
	<div class="col-md-3">
		@include('layouts.sidebar')
	</div>
	<div class="col-md-9 pull-right">
		<div class="page-header"><h1>{{ $title }}</h1></div>
		<br />
			@foreach($comics as $comic)
				@if(Request::path() == 'browse')
					<div class="col-md-4">
						<a href="#" data-target="drop-panel" class="hcaption" cap-effect="fade">
							{{ HTML::image($comic->cover_image, $comic->issue_id . $comic->book_id, array('width' => '100%')); }}
						</a>
						<div id="myToggle" class="cap-overlay">
							<h2 class="text-uppercase">{{ $comic->book_name.' #'.$comic->issue_id }}</h2>
							<br />
							<p>{{ $comic->summary }}</p>
						</div>
					</div>
				@else
					<div class="col-md-10 text-uppercase text-left">
						@if(Request::path() == 'browse/series')
							<li>{{ HTML::link(Request::path().'/'.$comic->book_name, $comic->book_name) }}</li>
						@endif
						@if(Request::path() == 'browse/authors')
							<li>{{ HTML::link(Request::path().'/'.$comic->author_name, $comic->author_name) }}</li>
						@endif
						@if(Request::path() == 'browse/artists')
							<li>{{ HTML::link(Request::path().'/'.$comic->artist_name, $comic->artist_name) }}</li>
						@endif
						@if(Request::path() == 'browse/publishers')
							<li>{{ HTML::link(Request::path().'/'.$comic->publisher_name, $comic->publisher_name) }}</li>
						@endif
						@if(Request::path() == 'browse/genre')
							<li>{{ HTML::link(Request::path().'/'.$comic->genre_name, $comic->genre_name) }}</li>
						@endif
						@if(Request::path() == 'browse/characters')
							<li>{{ HTML::link(Request::path().'/'.$comic->character_name, $comic->character_name) }}</li>
						@endif
						@if(Request::path() == 'browse/year')
							<li>{{ HTML::link(Request::path().'/'.$comic->year, $comic->year) }}</li>
						@endif
					</div>
				@endif
			@endforeach
	</div>
</div>