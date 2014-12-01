<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10 pull-left">
		<div class="page-header"><h1>{{ $title }}</h1></div>
		<br />
		@if(Session::has('postMsg'))
			 <div class="alert alert-warning alert-dismissible col-md-12" role="alert">
				  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				  {{ Session::get('postMsg') }}
			</div>
        @endif
			@foreach($comics as $comic)
				@if(Request::path() == 'browse')
					<div class="col-md-3 pull-left">
						<a href="#" data-target="drop-panel" class="hcaption" cap-effect="fade">
							{{ HTML::image($comic->cover_image, $comic->issue_id . $comic->book_id, array('width' => '242px', 'height'=> '373px')); }}
						</a>
						<div id="myToggle" class="cap-overlay">
							<h2 class="text-uppercase">{{ HTML::link(Request::path().'/series/'.$comic->book_name, $comic->book_name) }}<br/> {{ '#'.$comic->issue_id }}</h2>
							<p>{{ $comic->summary }}</p>
							{{ HTML::link(Request::path().'/series/'.$comic->book_name.'/'.$comic->issue_id , 'read more...', array('class'=>'btn btn-primary') ) }}
						</div>
					</div>
				@else
					<div class="col-md-10 text-uppercase text-left">
						@if(Request::path() == 'browse/series')
							<li>{{ HTML::link(Request::path().'/'.$comic->book_name, $comic->book_name, array('id' => $comic->book_name)) }}</li>
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
						@if(Request::path() == 'browse/genres')
							<li>{{ HTML::link(Request::path().'/'.$comic->genre_name, $comic->genre_name) }}</li>
						@endif
						@if(Request::path() == 'browse/characters')
							<li>{{ HTML::link(Request::path().'/'.$comic->character_name, $comic->character_name) }}</li>
						@endif
						@if(Request::path() == 'browse/years')
							<li>{{ HTML::link(Request::path().'/'.$comic->year, $comic->year) }}</li>
						@endif
					</div>
				@endif
			@endforeach
	</div>
</div>
<script>
	$.(document).ready(function() {
		$('a').click()
	})
</script>