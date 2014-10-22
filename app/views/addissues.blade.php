<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10 pull-left text-left">
		@if(Session::has('postMsg'))
            <h3 class="alert alert-warning" role="alert">{{ Session::get('postMsg') }}</h3>
        @endif
		{{ Form::open(array('route'=>'content.issue.store', 'id'=>'new_content', 'files'=>true, 'class'=>'form-horizontal')) }}
		{{ Form::hidden('id', $book_id->id); }}
			<h1 class="jumbotron">ADD AN ISSUE TO {{ $book_title }}</h1>
			<div class="col-md-4 pull-left thumbnail">
				{{ HTML::image(URL::asset('img/default-placeholder.png'), 'your image', array('id'=>'previewimg')) }}
				{{ Form::file('cover_image', array('class' => '', 'required'=>'', 'id'=>'previewbtn')); }}
				<span class="has-error">{{ $errors->first('cover_image') }}</span>
			</div>
			<div class="col-md-8 pull-right">
				<div class="form-group">
					{{ Form::label('ISSUE NUMBER','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::text('issue_number', Session::get('issue_number'), array('id'=>'issue_number', 'class'=>'form-control', 'placeholder'=>'What\'s the issue here!','required'=>'')) }}
						<p class="has-error">{{ $errors->first('issue_number') }}</p>
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('AUTHOR NAME','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::text('author_name', Session::get('author_name'), array('id'=>'author_name', 'class'=>'form-control', 'placeholder'=>'Someone must have written it.','required'=>'')) }}
						<p class="has-error">{{ $errors->first('author_name') }}</p>
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('ARTIST NAME','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::text('artist_name', Session::get('artist_name'), array('id'=>'artist_name','class'=>'form-control', 'placeholder'=>'So, who drew it.','required'=>'')) }}
						<p class="has-error">{{ $errors->first('artist_name') }}</p>
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('PUBLISHED DATE','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						<input id="published_date" class="form-control" type="date" required name="published_date" value="{{ Session::get('published_date') }}" style="background-image: none; background-position: 0% 0%; background-repeat: repeat;">
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('ISSUE SUMMARY (Optional)','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::textarea('issue_summary', Session::get('issue_summary'), array('id'=>'issue_summary','class'=>'form-control', 'placeholder'=>'Give us a summary, get us hooked.')) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-7 col-sm-5">
						{{ Form::submit('ADD NEW CONTENT', array('class'=>'btn btn-large btn-warning pull-right btn-block'))}}
						<br /><br />
						{{ HTML::link(URL::previous(), 'BACK', array('class'=>'btn btn-primary btn-block'))}}
					</div>		
				</div>	
			</div>
		{{ Form::close() }}
	</div>
</div>