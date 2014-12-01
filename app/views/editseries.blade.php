<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10 pull-left text-left">
		@if(Session::has('postMsg'))
            <div class="alert alert-warning alert-dismissible col-md-11" role="alert">
				  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				  {{ Session::get('postMsg') }}
			</div>
        @endif
		{{ Form::open(array('route'=>array('content.series.update', $book_title), 'method'=>'PUT', 'id'=>'edit_content', 'files'=>true, 'class'=>'form-horizontal')) }}
			@foreach($book_info as $info)
			<h1 class="jumbotron">{{ strtoupper($info->book_name) }}</h1>
			<div class="col-md-4 pull-left">
				<h4>INSTRUCTIONS: </h4>
				<blockquote>
					Edit this series.
				</blockquote>
			</div>
			<div class="col-md-8 pull-right">
				<div class="form-group">
					<input type="hidden" name="_method" value="PUT" />
					{{ Form::label('BOOK TITLE', '',array('class' => 'control-label col-md-3'))}}
					<div class="col-md-9">
						{{ Form::text('book_name', $info->book_name, array('id'=>'book_name', 'class'=>'form-control', 'placeholder'=>'Your series has to have a name.', 'required'=>'')) }}
						<p class="has-error">{{ $errors->first('book_name') }}</p>
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('PUBLISHER NAME','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::text('publisher_name', $info->publisher_name, array('id'=>'publisher_name','class'=>'form-control', 'placeholder'=>'These guys published it. Look at the top left corner.', 'required'=>'')) }}
						<p class="has-error">{{ $errors->first('publisher_name') }}</p>
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('GENRE','',array('class' => 'control-label col-md-3')) }}
				 	<div class="col-md-9 ddlGenres">
						<div class="dropdown">
							@foreach($selected_genres as $selected)
								{{ Form::select('genres[]', $book_genres, $selected->id, array('class' => 'form-control textupper')); }}
							@endforeach
						</div>
						<a id="removeGenre" class="pull-right"><span class="glyphicon glyphicon-minus"></span></a>
						<a id="addGenre" class="pull-left"><span class="glyphicon glyphicon-plus"></span></a>
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('SERIES SUMMARY (Optional)','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9">
						{{ Form::textarea('book_description', $info->book_description, array('id'=>'book_description','class'=>'form-control', 'placeholder'=>'Give us a summary, get us hooked.')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('CHARACTERS (Optional)','',array('class' => 'control-label col-md-3')) }}
					<div class="col-md-9 txtCharacters">
						<div class="textfield">
							@foreach($book_characters as $character)
							{{ Form::text('characters[]', Str::lower($character->character_name), array('id'=>'','class'=>'form-control characters', 'placeholder'=>'Character for your issue?')) }}
							@endforeach
						</div>
						<a id="removeCharacter" class="pull-right"><span class="glyphicon glyphicon-minus"></span></a>
						<a id="addCharacter" class="pull-left"><span class="glyphicon glyphicon-plus"></span></a>
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