<?php

class PostController extends BaseController {
	protected $layout = "layouts.master";

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
	}

	/**
	 * Display a listing of the resource.
	 * GET /addcontent
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['genres'] = DB::table('comicdb_genre')->orderby('genre_name', 'asc')->lists('genre_name', 'id');
		$this->layout->content = View::make('add', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /addcontent/create
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		//
		if ( Session::token() !== Input::get( '_token' ) ) {
			return Response::json( array(
			    'msg' => 'Unauthorized attempt to create option'
			) );
		}
		 
        $response = array(
            'status' => 'success',
            'msg' => 'Option created successfully',
        );
 
        return Response::json( $response );
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /addcontent
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /addcontent/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /addcontent/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /addcontent/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /addcontent/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}