<nav class="sidebar">
	<ul>
		<li>
			<input class="col-sm-2 form-control" type="search">
			<br /><br /><br />
		</li>
		<li class="{{ Request::is('browse/series') ? 'active' : '' }}">
			{{ HTML::link('/browse/series', 'SERIES') }}
		</li>
		<li class="{{ Request::is('browse/authors') ? 'active' : '' }}">
			{{ HTML::link('/browse/authors', 'AUTHORS') }}
		</li>
		<li class="{{ Request::is('browse/artists') ? 'active' : '' }}">
			{{ HTML::link('/browse/artists', 'ARTISTS') }}
		</li>

		<li class="{{ Request::is('browse/publishers') ? 'active' : '' }}">
			{{ HTML::link('/browse/publishers', 'PUBLISHERS') }}
		</li>
		<li class="{{ Request::is('browse/genre') ? 'active' : '' }}">
			{{ HTML::link('/browse/genre','GENRE') }}
		</li>
		<li class="{{ Request::is('browse/characters') ? 'active' : '' }}">
			{{ HTML::link('/browse/characters','CHARACTERS') }}
		</li>
		<li class="{{ Request::is('browse/year') ? 'active' : '' }}">
			{{ HTML::link('/browse/year','YEAR') }}
		</li>
		<li class="{{ Request::is('browse') ? 'active' : '' }}">
			{{ HTML::link('/browse','BROWSE THE LATEST') }}
		</li>
	</ul>
</nav>