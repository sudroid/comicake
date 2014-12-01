<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10 pull-left text-left">
		@if(Session::has('postMsg'))
            <div class="alert alert-warning alert-dismissible col-md-12" role="alert">
				  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				  {{ Session::get('postMsg') }}
			</div>
        @endif
         <div class="col-md-12 pull-left text-left">
			{{ Form::open(array('route'=>'content.series.store', 'id'=>'new_content', 'files'=>true, 'class'=>'form-horizontal')) }}
				<h1 class="jumbotron">ADD A NEW SERIES</h1>
				<div class="col-md-4 pull-left">
					<h4>INSTRUCTIONS: </h4>
					<blockquote>
						Once you've added a new series, you can go ahead and add issues to this series. 
					</blockquote>
				</div>
				<div class="col-md-8 pull-right">
					<div class="form-group">
						{{ Form::label('BOOK TITLE', '',array('class' => 'control-label col-md-3'))}}
						<div class="col-md-9">
							{{ Form::text('book_name', Session::get('book_name'), array('id'=>'book_name', 'class'=>'form-control', 'placeholder'=>'Your series has to have a name.', 'required'=>'')) }}
							<p class="has-error">{{ $errors->first('book_name') }}</p>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('PUBLISHER NAME','',array('class' => 'control-label col-md-3')) }}
						<div class="col-md-9">
							{{ Form::text('publisher_name', Session::get('publisher_name'), array('id'=>'publisher_name','class'=>'form-control', 'placeholder'=>'These guys published it. Look at the top left corner.', 'required'=>'')) }}
							<p class="has-error">{{ $errors->first('publisher_name') }}</p>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('GENRE','',array('class' => 'control-label col-md-3')) }}
					 	<div class="col-md-9 ddlGenres">
							<div class="dropdown">
								{{ Form::select('genres[]', DB::table('comicdb_genre')->lists('genre_name', 'id'), 'id', array('class' => 'form-control textupper')); }}
							</div>
							<a id="removeGenre" class="pull-right"><span class="glyphicon glyphicon-minus"></span></a>
							<a id="addGenre" class="pull-left"><span class="glyphicon glyphicon-plus"></span></a>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('SERIES SUMMARY (Optional)','',array('class' => 'control-label col-md-3')) }}
						<div class="col-md-9">
							{{ Form::textarea('book_description', Session::get('book_description'), array('id'=>'book_description','class'=>'form-control', 'placeholder'=>'Give us a summary, get us hooked.')) }}
						</div>
					</div>
				</div>
				<hr style="clear:both">
				<h1 class="jumbotron">ADD AN ISSUE TO YOUR SERIES</h1>
				<div class="col-md-4 pull-left thumbnail">
					{{ HTML::image(URL::asset('img/default-placeholder.png'), 'your image', array('id'=>'previewimg')) }}
					{{ Form::file('cover_image', array('class' => '', 'required'=>'', 'id'=>'previewbtn')); }}
					<span class="has-error">{{ $errors->first('cover_image') }}</span>
				</div>
				<div class="col-md-8 pull-right">
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
							<input id="published_date" class="form-control" type="date" required name="published_date" value="" style="background-image: none; background-position: 0% 0%; background-repeat: repeat;">
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('ISSUE SUMMARY (Optional)','',array('class' => 'control-label col-md-3')) }}
						<div class="col-md-9">
							{{ Form::textarea('issue_summary', Session::get('issue_summary'), array('id'=>'issue_summary','class'=>'form-control', 'placeholder'=>'Give us a summary, get us hooked.')) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('CHARACTERS (Optional)','',array('class' => 'control-label col-md-3')) }}
						<div class="col-md-9 txtCharacters">
							<div class="textfield">
								{{ Form::text('characters[]', '', array('id'=>'','class'=>'form-control characters', 'placeholder'=>'Character for your issue?')) }}
							</div>
							<a id="removeCharacter" class="pull-right"><span class="glyphicon glyphicon-minus"></span></a>
							<a id="addCharacter" class="pull-left"><span class="glyphicon glyphicon-plus"></span></a>
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
</div>