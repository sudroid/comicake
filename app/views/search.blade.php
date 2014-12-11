<div class="row search"> 
	<h1>What have we here...</h1>
	<div class="col-md-2">
		<h1 class="search-header">SERIES</h1>
		<div class="col-sm-10">
			<ul>
				@foreach($comics as $comic)
					<li>{{ HTML::link('browse/series/'.$comic->book_name, Str::upper($comic->book_name)) }}</li>
				@endforeach
			</ul>
		</div>
	</div>
	<div class="col-md-2">
		<h1 class="search-header">CHARACTERS</h1>
		<div class="col-sm-10">
			<ul>
				@foreach($characters as $character)
					<li>{{ HTML::link('browse/characters/'.$character->character_name, Str::upper($character->character_name)) }}</li>
				@endforeach
			</ul>
		</div>
	</div>
	<div class="col-md-2">
		<h1 class="search-header">AUTHORS</h1>
		<div class="col-sm-10">
			<ul>
				@foreach($authors as $author)
					<li>{{ HTML::link('browse/authors/'.$author->author_name, Str::upper($author->author_name)) }}</li>
				@endforeach
			</ul>
		</div>
	</div>
	<div class="col-md-2">
		<h1 class="search-header">ARTISTS</h1>
		<div class="col-sm-10">
			<ul>
				@foreach($artists as $artist)
					<li>{{ HTML::link('browse/artists/'.$artist->artist_name, Str::upper($artist->artist_name)) }}</li>
				@endforeach
			</ul>
		</div>
	</div>
	<div class="col-md-2">
		<h1 class="search-header">PUBLISHERS</h1>
		<div class="col-sm-10">
			<ul>
				@foreach($publishers as $publisher)
					<li>{{ HTML::link('browse/publishers/'.$publisher->publisher_name, Str::upper($publisher->publisher_name)) }}</li>
				@endforeach
			</ul>
		</div>
	</div> 
	<div class="col-md-12 bottom">
		<p>Didn't find what you were looking for? If it's missing, you should add it.</p>
	</div>
</div>