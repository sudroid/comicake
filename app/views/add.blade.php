<div class="row">
	<div class="col-md-3">
		@include('layouts.sidebar')
	</div>
	<div class="col-md-8 pull-left text-left">
		{{ Form::open(array('url'=>'post/create', 'method'=>'post', 'id'=>'new_content', 'files'=>true, 'class'=>'form-horizontal')) }}
			<h1 class="jumbotron">ADD NEW CONTENT</h1>
			<div class="col-md-4 pull-left">
				<h4>INSTRUCTIONS: </h4>
				<blockquote>
					Add a new series! <br />
					Once you've added a new series, you can go ahead and add issues to this series. 
				</blockquote>
			</div>
			<div class="col-md-8 pull-right">
				<div class="form-group">
					{{ Form::label('SERIES TITLE', '',array('class' => 'control-label col-md-3'))}}
					<div class="col-md-9">
						{{ Form::text('series', '', array('id'=>'series', 'class'=>'form-control', 'placeholder'=>'Your series has to have a name.', 'required'=>'')) }}
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
				 	<div class="col-md-9 ">
						<div class="dropdown">
							{{ Form::select('genres', DB::table('comicdb_genre')->lists('genre_name', 'id'), 'id', array('class' => 'form-control textupper')); }}
						</div>
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('SERIES SUMMARY (Optional)','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::textarea('series_summary', '', array('id'=>'series_summary','class'=>'form-control', 'placeholder'=>'Give us a summary, get us hooked.')) }}
					</div>
				</div>
			</div>
			<hr style="clear:both">
			<h1 class="jumbotron">ADD NEW ISSUE</h1>
			<div class="col-md-4 pull-left thumbnail">
				<img id="previewimg" src="img/default-placeholder.png" alt="your image" />
				{{ Form::file('file', array('class' => '', 'required'=>'', 'id'=>'previewbtn')); }}
			</div>
			<div class="col-md-8 pull-right">
				
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
					{{ Form::label('PUBLISHED DATE','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						<input id="published_date" class="form-control" type="date" required name="published_date" value="" style="background-image: none; background-position: 0% 0%; background-repeat: repeat;">
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('ISSUE SUMMARY (Optional)','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::textarea('issue_summary', '', array('id'=>'issue_summary','class'=>'form-control', 'placeholder'=>'Give us a summary, get us hooked.')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('CHARACTERS (Optional)','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::textarea('characters', '', array('id'=>'characters','class'=>'form-control', 'placeholder'=>'Seperate characters by commas.')) }}
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