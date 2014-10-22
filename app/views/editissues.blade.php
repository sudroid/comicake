<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10 pull-left text-left">
		@if(Session::has('postMsg'))
            <h3 class="alert alert-warning" role="alert">{{ Session::get('postMsg') }}</h3>
        @endif
		{{ Form::open(array('route'=>array('content.issue.update', $issue_id),'method'=>'PUT', 'id'=>'edit_content', 'files'=>true, 'class'=>'form-horizontal')) }}
		{{ Form::hidden('id', $book_id->id); }}
			@foreach($book_info as $info)
			<h1 class="jumbotron">EDIT ISSUE <em>#{{ $issue_id }}</em> OF {{ $book_title }}</h1>
			<div class="col-md-4 pull-left thumbnail">
				{{ HTML::image(URL::asset($info->cover_image), 'your image', array('id'=>'previewimg')) }}
				{{ Form::file('cover_image', array('class' => '', 'id'=>'previewbtn')); }}
				<span class="has-error">{{ $errors->first('cover_image') }}</span>
			</div>
			<div class="col-md-8 pull-right">
				<div class="form-group">
					<input type="hidden" name="_method" value="PUT" />
					{{ Form::label('ISSUE NUMBER','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::text('issue_number', $info->issue_id, array('id'=>'issue_number', 'class'=>'form-control', 'placeholder'=>'What\'s the issue here!','required'=>'')) }}
						<p class="has-error">{{ $errors->first('issue_number') }}</p>
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('AUTHOR NAME','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::text('author_name', $info->author_name, array('id'=>'author_name', 'class'=>'form-control', 'placeholder'=>'Someone must have written it.','required'=>'')) }}
						<p class="has-error">{{ $errors->first('author_name') }}</p>
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('ARTIST NAME','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::text('artist_name', $info->artist_name, array('id'=>'artist_name','class'=>'form-control', 'placeholder'=>'So, who drew it.','required'=>'')) }}
						<p class="has-error">{{ $errors->first('artist_name') }}</p>
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('PUBLISHED DATE','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						<input id="published_date" class="form-control" type="date" required name="published_date" value="{{ $info->published_date }}" style="background-image: none; background-position: 0% 0%; background-repeat: repeat;">
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('ISSUE SUMMARY (Optional)','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::textarea('issue_summary', $info->summary, array('id'=>'issue_summary','class'=>'form-control', 'placeholder'=>'Give us a summary, get us hooked.')) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-7 col-sm-5">
						{{ Form::submit('SAVE CONTENT', array('class'=>'btn btn-large btn-warning pull-right btn-block'))}}
						<br /><br />
						{{ HTML::link(URL::previous(), 'BACK', array('class'=>'btn btn-primary btn-block'))}}
					</div>		
				</div>	
			</div>
			@endforeach
		{{ Form::close() }}
	</div>
</div>