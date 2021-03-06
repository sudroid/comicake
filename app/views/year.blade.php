<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-11 pull-left">
		<h1 class="text-uppercase">{{ $year_name }}</h1>
		<br />
		<div class="col-md-6 pull-left text-left text-uppercase">
			<h4>Latest Additions...</h4>
				<a href="{{'/browse/series/'.$year_works[0]->book_name }}">
					{{ HTML::image($year_cover[0]->cover_image, $year_works[0]->book_name, array('width' => '75%')); }}
				</a>
		</div>
		<div class="col-md-5 pull-left text-uppercase text-left">
			<h4>Others...</h4>
			<ul>
				@foreach($year_works as $work)
						<li>{{ HTML::link('/browse/series/'.$work->book_name, $work->book_name) }}</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>