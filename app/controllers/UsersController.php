<?php
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class UsersController extends BaseController {
	protected $layout = "layouts.master";

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth', array('only'=>array('getDashboard', 'getAdmin')));
		$this->beforeFilter('auth.admin', array('only'=>array('getAdmin')));
	}

	public function index() 
	{
		$this->layout->content = View::make('login');
	}

	public function getRegister() {
    	$this->layout->content = View::make('register');
	}

	/** NOTE ABOUT PASSWORDS: 
	 * Hash::make($value) creates a hash using password_hash($value, PASSWORD_BCRYPT, array('cost' => $cost)) 
	 * See http://nl1.php.net/manual/en/function.password-hash.php 
	 * This is 1-way. You can never get the original string back. 
	 *
	 * The first part of the generated hash, exists of the used algorithm and the salt.
	 * So when you pass in the original hash in Hash::check(), you can check if you get the same result. 
	 * See http://nl1.php.net/manual/en/function.password-verify.php 
	 *
	 * Laravel uses BCRYPT, so you have to see if you can use that.
	*/
	public function postCreate() {
		$validator = Validator::make(Input::all(), User::$rules);

		if ($validator->passes()) {
			$user = new User;
			$user->username = Input::get('username');
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->save();

			return Redirect::to('login')->with('message', 'Thanks for registering!');
		} else {
			return Redirect::to('register')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}

	public function getLogin() {
		$this->layout->content = View::make('login');
	}

	public function postSignin() {
		if (Auth::attempt(array('username'=>Input::get('username'), 'password'=>Input::get('password'), 'active' => 1))) {
			return Redirect::to('dashboard')->with('message', 'You are now logged in!');
		} else {
			return Redirect::to('login')
				->with('message', 'Your username/password combination was incorrect')
				->withInput();
		}
	}

	public function getDashboard() {
		$user 		= Auth::user()->id;
		$admin 		= Auth::user()->admin;
		$active 	= Auth::user()->active;
		$data['admin_msg'] = ($admin == 0) ? 'USER' : 'ADMIN';
		$data['active_msg'] = ($active == 0) ? 'INACTIVE' : 'ACTIVE';

		$data['user_read'] = Userinfo::Userbookread($user)->where('read_status', 1)->select('book_name')->get();
		$data['user_to_read'] = Userinfo::Userbookread($user)->where('reading_status', 1)->select('book_name')->get();
		
		$this->layout->content = View::make('users.dashboard', $data);
	}

	public function getAdmin(){
		$data['users_inactive'] = User::where('active', '=', 0)->get();
		$data['users_active'] 	= User::where('active', '=', 1)->get();
		$data['recent_books'] 	= Comicbooks::select('book_name','updated_at')->orderBy('updated_at', 'desc')->paginate(3);
		$data['user_count']		= User::where('id', '>', 0)->count();
		$data['publisher_count']= Publishers::where('id', '>', 0)->count();
		$data['books_count']	= Comicbooks::where('id', '>', 0)->count();
		$data['issue_count']	= Comicissues::where('issue_id', '>', 0)->where('book_id', '>', 0)->count();
		$data['artist_count']	= DB::table('comicdb_artists')->count(); 
		$data['author_count']	= DB::table('comicdb_authors')->count();
		$this->layout->content 	= View::make('admin.index', $data);
	}

	public function getLogout() {
		Auth::logout();
		return Redirect::to('login')->with('message', 'Your are now logged out!');
	}
}