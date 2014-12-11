<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-11 pull-left">
		<div class="col-md-10 pull-left text-left jumbotron">
			<h1 class="text-uppercase">{{ $artist_name }}</h1>
			<p>{{ HTML::link("http://en.wikipedia.org/wiki/".$artist_name, "Know More") }}</p>
		</div>
		<div class="col-md-10 pull-left text-uppercase text-left">
			<div class="col-md-5 pull-left text-uppercase text-left">
				<h4>Latest Additions...</h4>
				<a href="{{'/browse/series/'.$artist_works[0]->book_name }}">
					{{ HTML::image($artist_cover[0]->cover_image, $artist_works[0]->book_name, array('width' => '75%')); }}
				</a>
			</div>
			<div class="col-md-5 pull-left text-uppercase text-left">
				<h4>Others...</h4>
				<ul>
					@foreach($artist_works as $work)
							<li>{{ HTML::link('/browse/series/'.$work->book_name, $work->book_name) }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>