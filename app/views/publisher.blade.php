<div class="row">
	<div class="col-md-3">
		@include('layouts.sidebar')
	</div>
	<div class="col-md-8 pull-left">
		<h1 class="text-uppercase">{{ $publisher_name }}</h1>
		<br />
		<div class="col-md-6 pull-left text-left text-uppercase">
			<h4>Latest...</h4>
				<a href="{{'/browse/series/'.$publisher_works[0]->book_name }}">
					{{ HTML::image($publisher_cover[0]->cover_image, $publisher_works[0]->book_name, array('width' => '75%')); }}
				</a>
		</div>
		<div class="col-md-5 pull-left text-uppercase text-left">
			<h4>Others...</h4>
			<ul>
				@foreach($publisher_works as $work)
						<li>{{ HTML::link('/browse/series/'.$work->book_name, $work->book_name) }}</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>