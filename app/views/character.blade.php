<div class="row">
	<div class="col-md-3">
		@include('layouts.sidebar')
	</div>
	<div class="col-md-9 pull-right">
		<div class="col-md-2"></div>
		<div class="col-md-10 pull-left text-left jumbotron">
			<h1 class="text-uppercase">{{ $character_name }}</h1>
			<p>Biography</p>
			<blockquote>{{ $character_works[0]->character_description }}</blockquote>
		</div>
		<div class="col-md-2"></div>
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