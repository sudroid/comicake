<blockquote>
	<p>You have received this email because you have forgotten your password.</p>
	<p>To reset your password, complete this form:</p>
	<br> 
	<blockquote> 
		{{ URL::to('password/reset', array($token)) }}
	</blockquote>
</blockquote>