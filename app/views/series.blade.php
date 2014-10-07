<div class="row">
	<div class="col-md-3">
		@include('layouts.sidebar')
	</div>
	<div class="col-md-9 pull-right">
		<h1 class="text-uppercase">{{ $book_title }}</h1>
		<br />
		<div class="col-md-6 pull-left">
			{{ HTML::image($book_info[0]->cover_image, $book_info[0]->issue_id . $book_info[0]->book_id, array('width' => '100%')); }}
		</div>
		<div class="col-md-6 pull-left text-uppercase text-left">
			<dl class="dl-horizontal">	
				<dt>Genre:<dt> <dd> {{ HTML::link('browse/genre/'.$book_info[0]->genre_name, $book_info[0]->genre_name ) }}</dd>
				<dt>Publisher:<dt> <dd> {{ HTML::link('browse/publisher/'.$book_info[0]->publisher_name, $book_info[0]->publisher_name ) }}</dd>
				<dt>Description:<dt> <dd>{{ $book_info[0]->book_description }}</dd>
			</dl>
			<ul>
				@foreach($book_info as $info)
					<li>{{ HTML::link('browse/series/'.$book_title.'/'.$info->issue_id, 'Issue #'.$info->issue_id)}}
				@endforeach
			</ul>
		</div>
	</div>
</div>