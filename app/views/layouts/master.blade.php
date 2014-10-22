<!doctype html>
<html lang="en">
<head>
	@include('includes.head')
<body>
    @if(Request::path() != '/')
        @include('includes.navbar')
    @endif
    <div class="container-fluid main">
        @if(Request::path() != '/') 
            @include('layouts.sidebar')
        @endif
        @if(Session::has('message'))
            <p class="alert">{{ Session::get('message') }}</p>
        @endif
        {{ $content }}
    </div>
</body>
@include('includes.foot')

</html>
