<div class="row">
	<div class="col-md-3">
		@include('layouts.sidebar')
	</div>
	<div class="col-md-8 pull-left">
		<h1 class="text-uppercase">{{ $book_title }}</h1>
		<br />
		<div class="col-md-8 pull-left text-uppercase text-left">
			<dl class="dl-horizontal">	
				<dt>Genre:<dt> 
					@foreach($book_genre as $genre)
						<dd>{{ HTML::link('browse/genre/'.$genre->genre_name, $genre->genre_name ) }}</dd>
					@endforeach
				<dt>Publisher:<dt> <dd> {{ HTML::link('browse/publisher/'.$book_info[0]->publisher_name, $book_info[0]->publisher_name ) }}</dd>
				<dt>Description:<dt> <dd>{{ $book_info[0]->book_description }}</dd>
			</dl>
		</div>
		@if(Auth::check())
			<div class="col-md-4 pull-left text-uppercase text-left issues_list">
					{{ HTML::link('edit/series/'.$book_title, 'EDIT SERIES INFORMATION', array('class'=>'btn btn-primary btn-block'))}}
					{{ HTML::link('post', 'ADD NEW ISSUE', array('class'=>'btn btn-primary btn-block'))}}
					{{ HTML::link(URL::previous(), 'BACK', array('class'=>'btn btn-primary btn-block'))}}
			</div>
		@else
			<div class="col-md-4 pull-left text-uppercase text-left issues_list">
				{{ HTML::link(URL::previous(), 'BACK', array('class'=>'btn btn-primary btn-block'))}}
			</div>
		@endif
		<div class="col-md-12">
			@if(isset($book_issues))
				@foreach($book_issues as $issue)
					<div class="col-md-2 pull-left">
						<a href='{{ $book_title }}/{{ $issue->issue_id }}' >{{ HTML::image($issue->cover_image, $book_title . $issue->issue_id, array('width' => '100%', 'class'=>'img-rounded')); }}</a>
					</div>
				@endforeach
			@endif
		</div>
	</div>
</div>