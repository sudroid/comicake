@extends('layouts.master')

@section('content')
	<div class="welcome">
		ALL USERS HERE
		@foreach ($users as $user) 
			<li>{{ link_to("/admin/{$user->username", $user->username) }}</li>
		@endforeach
	</div>
@stop
