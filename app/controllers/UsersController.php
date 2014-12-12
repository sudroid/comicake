<?php
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class UsersController extends BaseController {

	//Protected variable - master layout
	protected $layout = "layouts.master";

	/*
	*	Constructor sets beforeFilters
	*/
	public function __construct() {
		//See filters.php
		//Laravel contains a built in protectin for cross-site request forgery on POST. 
		$this->beforeFilter('csrf', array('on'=>'post'));
		//Auth filter 
		// Only users can accesss these methods 
		$this->beforeFilter('auth', array('only'=>array('getDashboard', 'getAdmin', 'postDeactivate')));
		//Admin filter
		// Only admin can access destroy (delete an user)
		$this->beforeFilter('auth.admin', array('only'=>array('getAdmin', 'deleteUser')));
	}

	/*
	*	Show the login page
	*/
	public function index() 
	{
		$this->layout->content = View::make('login');
	}

	/*
	*	Show the registeration page
	*/
	public function getRegister() {
    	$this->layout->content = View::make('register');
	}

	/*
	*	Create a new user	
	*
	* 	NOTE ABOUT PASSWORDS: 
	* 	Hash::make($value) creates a hash using password_hash($value, PASSWORD_BCRYPT, array('cost' => $cost)) 
	* 	See http://nl1.php.net/manual/en/function.password-hash.php 
	* 	This is 1-way. You can never get the original string back. 
	*
	* 	The first part of the generated hash exists of the used algorithm and the salt.
	* 	So when you pass in the original hash in Hash::check(), you can check if you get the same result. 
	* 	See http://nl1.php.net/manual/en/function.password-verify.php 
	*
	* 	Laravel uses BCRYPT.
	*/
	public function postCreate() {
		$validator = Validator::make(Input::all(), User::$rules);

		if ($validator->passes()) {
			$user 			= new User;
			$user->username = Input::get('username');
			$user->email 	= Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->save();

			return Redirect::to('login')->with('message', 'Thanks for registering!');
		} else {
			return Redirect::to('register')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}

	/*
	*	Show the login page
	*/
	public function getLogin() {
		$this->layout->content = View::make('login');
	}

	/*
	*	Handle the signin process
	*/
	public function postSignin() {
		//Attempt to sign in using inptu data 
		if (Auth::attempt(array('username'=>Input::get('username'), 'password'=>Input::get('password'), 'active' => 1))) {
			return Redirect::to('dashboard')->with('message', 'You are now logged in!');
		} else {
			return Redirect::to('login')
				->with('message', 'Your username/password combination was incorrect')
				->withInput();
		}
	}

	/*
	*	Show the user dashboard
	*/
	public function getDashboard() {
		//Get info
		$user 					= Auth::user()->id;
		$admin 					= Auth::user()->admin;
		$active 				= Auth::user()->active;
		$data['admin_msg'] 		= ($admin == 0) ? 'USER' : 'ADMIN';
		$data['active_msg'] 	= ($active == 0) ? 'INACTIVE' : 'ACTIVE';
		$data['user_read'] 		= Userinfo::Userbookread($user)->where('read_status', 1)->select('book_name')->get();
		$data['user_to_read'] 	= Userinfo::Userbookread($user)->where('reading_status', 1)->select('book_name')->get();
		$data['read_publisher'] = Userinfo::UserReadPublisher($user)->select(DB::raw('count(*) as count'), 'publisher_name')->groupby('publisher_name')->get();
		$data['read_genre']	  	= Userinfo::UserReadGenre($user)->select(DB::raw('count(*) as count'), 'genre_name')->groupby('genre_name')->get();
		$data['read_publisher_name'] 	= "";
		$data['read_publisher_count'] 	= "";
		$data['read_genre_name'] 		= "";
		$data['read_genre_count']		= "";
		//Check if the user has anything in the userinfo table for read comicbook series and publisher
		if (count($data['read_publisher']) != 0) {
			//Set data into an array to then returns a json encoded string
			foreach ($data['read_publisher'] as $count) {
				$publisher_name[] = $count->publisher_name;
				$publisher_count[]= $count->count;
			}
			$data['read_publisher_name']  = json_encode($publisher_name);
			$data['read_publisher_count'] = json_encode($publisher_count);
		}

		//Check if the user has anything in the userinfo table for read comicbook series and genre
		if(count($data['read_genre']) != 0) {
			//Set data into an array to then returns a json encoded string
			foreach ($data['read_genre'] as $count) {
				$genre_name[] = $count->genre_name;
				$genre_count[]  = $count->count;
			}
			$data['read_genre_name'] = json_encode($genre_name);
			$data['read_genre_count']= json_encode($genre_count);
		}
		$this->layout->content 	= View::make('users.dashboard', $data);
	}

	/*
	*	Show the admin page
	*/
	public function getAdmin(){
		//Get info
		$data['users'] = User::paginate(5);
		$data['recent_books'] 	= Comicbooks::select('book_name','updated_at')->orderBy('updated_at', 'desc')->paginate(3);
		$data['user_count']		= User::where('id', '>', 0)->count();
		$data['publisher_count']= Publishers::where('id', '>', 0)->count();
		$data['books_count']	= Comicbooks::where('id', '>', 0)->count();
		$data['issue_count']	= Comicissues::where('issue_id', '>', 0)->where('book_id', '>', 0)->count();
		$data['artist_count']	= Artists::count(); 
		$data['author_count']	= Authors::count();
		$data['books_created']	= Comicbooks::select(DB::raw('count(*) as count'), 'created_at')->groupby(DB::raw('date_format(created_at, "%b %Y")'))->orderby('created_at', 'asc')->get();
		$data['issues_created']	= Comicissues::select(DB::raw('count(*) as count'), 'created_at')->groupby(DB::raw('date_format(created_at, "%b %Y")'))->orderby('created_at', 'asc')->get();

		//Check if there are any comicbook series
		if(count($data['books_created']) > 0) {
			//Get the count of books per the month/year then return the json encoded string
			foreach($data['books_created'] as $created) {
				$created_books[] = $created->count;
				$created_books_date[] = date_format($created->created_at, "M Y");
			}
			$data['created_books'] = json_encode($created_books);
		}

		//Check if there are any comicbook issue
		if(count($data['issues_created']) > 0) {
			//Get the count of issues per the month/year then return the json encoded string
			foreach($data['issues_created'] as $created) {
				$created_issues[] = $created->count;
				$created_issues_date[] = date_format($created->created_at, "M Y");
			}
			$data['created_issues'] = json_encode($created_issues);
		}

		//Merge dates from comicbook series and issues created then return the json encoded string
		$data['created_dates'] = json_encode(array_unique(array_merge($created_issues_date, $created_books_date)));
 		$this->layout->content 	= View::make('admin.index', $data);
	}

	/*
	*	Handle the logout process
	*/
	public function getLogout() {
		//Logout
		Auth::logout();
		//Destroy session
		Session::flush();
		return Redirect::to('login')->with('message', 'Your are now logged out!');
	}

	/*
	*	Handle user deactivation by updating the status to inactive (bool - 0)
	*/
	public function postDeactivate(){
		//Check if user is active, if not then find the user and set their active status to deactivated
		if (Auth::user()->active) {
			$user = User::find(Auth::user()->id);
			$user->active = 0;
			$user->save();
			$this->getLogout();
		}
		return Redirect::to('browse')->with('message', 'We\'re sorry to see you go... :(');
	}

	/*
	*	Remove a user from the database
	*/
	public function destroy($id)
	{
		//Message that's returned
		$msg = '<div class="alert alert-warning alert-dismissible col-md-12" role="alert">
					  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					 	User Deleted!
				</div>';
		//Delete userinfo with that user's data
		Userinfo::deleteUser($id);
		//Delete user
		User::findOrFail($id);	
		User::destroy($id);
		return Redirect::to('admin')->with('message', $msg);
	}
}