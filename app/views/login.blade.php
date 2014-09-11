<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ $title }}</title>
	<!-- Minified Jquery --> 	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<!-- Themed CSS -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/css/bootstrap-theme.min.css" />
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #fff;
			background-color:#FF5258
		}

		.welcome {
			width: 400px;
			height: 400px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -200px;
			margin-top: -100px;
		}

		a, a:visited {
			text-decoration:none;
		}
	</style>
</head>
<body>
	<div class="welcome">
		<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label" for="inputEmail">Email</label>
				<div class="controls">
					<input type="text" id="inputEmail" placeholder="Email">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPassword">Password</label>
				<div class="controls">
					<input type="password" id="inputPassword" placeholder="Password">
				</div>
			</div>			
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn">Sign in</button>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<a href="">Forgot Your Password?</a>
				</div>
			</div>
		</form>
	</div>
</body>
</html>
