<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-11 pull-left">
		<div class="col-md-10 pull-left text-left jumbotron">
			<h1 class="text-uppercase">{{ $character_name }}</h1>
		</div>
		<div class="col-md-3 pull-left text-uppercase text-left">
			{{ HTML::image($image, $character_works[0]->book_name, array('width' => '100%')); }}
		</div>
		<div class="col-md-3 pull-left text-uppercase text-left">
			<h1>Aliases:</h1>
			{{ HTML::ul([$aliases]); }}
		</div>
		<div class="col-md-4 pull-left text-uppercase text-left">
			<h1 class="text-uppercase">Info:</h1> <p>{{ $description }}</p>
			<h1 class="text-uppercase">Extras:</h1> 
			<p>Publisher: {{ HTML::link('/browse/publishers/'.$publisher, $publisher) }}</p>
			<p>Number of Appearances: {{ $appearances_count }}</p>
			<p>{{ HTML::link($detail_url, "READ MORE AT COMIC VINE") }}</p>
		</div>
		<div class="col-md-10 pull-left text-uppercase text-left">
			<div class="col-md-5 pull-left text-uppercase text-left">
				<h4>Appeared in...</h4>
				<ul>
					@foreach($character_works as $work)
							<li>{{ HTML::link('/browse/series/'.$work->book_name, $work->book_name) }}</li>
					@endforeach
				</ul>
			</div>
			<div class="col-md-5 pull-left text-uppercase text-left">
				<h4>Latest appearance...</h4>
				<a href="{{'/browse/series/'.$character_works[0]->book_name }}">
					{{ HTML::image($character_cover[0]->cover_image, $character_works[0]->book_name, array('width' => '35%')); }}
				</a>
			</div>
		</div>
	</div>
</div>