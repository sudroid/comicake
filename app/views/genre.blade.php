<div class="row">
	<div class="col-md-3">
		@include('layouts.sidebar')
	</div>
	<div class="col-md-8 pull-left">
		<h1 class="text-uppercase">{{ $genre_name }}</h1>
		<br />
		<div class="col-md-6 pull-left text-left text-uppercase">
			<h4>Latest...</h4>
				<a href="{{'/browse/series/'.$genre_works[0]->book_name }}">
					{{ HTML::image($genre_cover[0]->cover_image, $genre_works[0]->book_name, array('width' => '75%')); }}
				</a>
		</div>
		<div class="col-md-5 pull-left text-uppercase text-left">
			<h4>Others...</h4>
			<ul>
				@foreach($genre_works as $work)
						<li>{{ HTML::link('/browse/series/'.$work->book_name, $work->book_name) }}</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>