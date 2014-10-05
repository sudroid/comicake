<!doctype html>
<html lang="en">
<head>
	@include('includes.head')
<script>
    $(window).load(function(){
        $('.hcaption').hcaptions({
            effect: "fade"
        });
    });
</script>
<body>
    @if(Request::path() != '/')
        @include('includes.navbar')
    @endif
    <div class="container">
        @if(Session::has('message'))
            <p class="alert">{{ Session::get('message') }}</p>
        @endif
        {{ $content }}
    </div>
</body>
</html>
