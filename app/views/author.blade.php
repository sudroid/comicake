<div class="row">
	<div class="col-md-3">
		@include('layouts.sidebar')
	</div>
	<div class="col-md-9 pull-right">
		<div class="col-md-2"></div>
		<div class="col-md-10 pull-left text-left jumbotron">
			<h1 class="text-uppercase">{{ $author_name }}</h1>
			<p>Biography</p>
			<blockquote>{{ $author_works[0]->author_description }}</blockquote>
			<br />
		</div>
		<div class="col-md-2"></div>
		<div class="col-md-10 pull-left text-uppercase text-left">
			<div class="col-md-5 pull-left text-uppercase text-left">
				<h4>Latest...</h4>
				<a href="{{'/browse/series/'.$author_works[0]->book_name }}">
					{{ HTML::image($author_cover[0]->cover_image, $author_works[0]->book_name, array('width' => '75%')); }}
				</a>
			</div>
			<div class="col-md-5 pull-left text-uppercase text-left">
				<h4>Others...</h4>
				<ul>
					@foreach($author_works as $work)
							<li>{{ HTML::link('/browse/series/'.$work->book_name, $work->book_name) }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>