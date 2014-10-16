<div class="row">
	<div class="col-md-3">
		@include('layouts.sidebar')
	</div>
	<div class="col-md-8 pull-left text-left">
		{{ Form::open(array('url'=>'post/create', 'method'=>'post', 'id'=>'new_content', 'files'=>true, 'class'=>'form-horizontal')) }}
			<h2>ADD NEW CONTENT</h2>
			<div class="col-md-4 pull-left thumbnail">
				<img id="previewimg" src="img/default-placeholder.png" alt="your image" />
				{{ Form::file('file', array('class' => '', 'required'=>'', 'id'=>'previewbtn')); }}
			</div>
			<div class="col-md-8 pull-right">
				<div class="form-group">
					{{ Form::label('SERIES TITLE', '',array('class' => 'control-label col-md-3'))}}
					<div class="col-md-9">
						{{ Form::text('series', '', array('id'=>'series', 'class'=>'form-control', 'placeholder'=>'Your series has to have a name.', 'required'=>'')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('AUTHOR NAME','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::text('author', '', array('id'=>'author', 'class'=>'form-control', 'placeholder'=>'Someone must have written it.','required'=>'')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('ARTIST NAME','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::text('artist', '', array('id'=>'artist','class'=>'form-control', 'placeholder'=>'So, who drew it.','required'=>'')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('PUBLISHER NAME','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::text('publisher', '', array('id'=>'publisher','class'=>'form-control', 'placeholder'=>'These guys published it. Look at the top left corner.', 'required'=>'')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('GENRE','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::text('genre', '', array('id'=>'genre','class'=>'form-control', 'placeholder'=>'Where DO you think it belongs?','required'=>'')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('PUBLISHED DATE','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						<input id="published_date" class="form-control" type="date" required name="published_date" value="" style="background-image: none; background-position: 0% 0%; background-repeat: repeat;">
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('SERIES SUMMARY (Optional)','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::textarea('published_date', '', array('id'=>'published_date','class'=>'form-control', 'placeholder'=>'Give us a summary, get us hooked.')) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					{{ Form::submit('ADD NEW CONTENT', array('class'=>'btn btn-large btn-warning pull-right'))}}
					</div>		
				</div>	
			</div>
		{{ Form::close() }}
	</div>
	@if($_POST)
		<pre>{{ $files }}</pre>
		<pre>{{ $post }}</pre>
	@endif
</div>