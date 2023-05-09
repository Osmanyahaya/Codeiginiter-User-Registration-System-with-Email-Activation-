<?php
namespace App\Controllers\Auth;

use CodeIgniter\Controller;
use Config\Email;
use Config\Services;
use App\Models\UserModel;
use App\Models\LogsModel;

class UsersController extends Controller
{

	/**
	 * Access to current session.
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * Authentication settings.
	 */
	protected $config;


    //--------------------------------------------------------------------

	public function __construct()
	{
		// start session
		$this->session = Services::session();
	}

    //--------------------------------------------------------------------

	/**
	 * Displays users page.
	 */
	public function users()
	{
		// check if user is signed-in if not redirect to login page
		if (! $this->session->isLoggedIn) {
			return redirect()->to('login');
		}


		// current year and month variable 
		$ym = date("Y-m");

		// load user model
		$users = new UserModel();

		// getall users
		$allusers = $users->findAll(); 

		// count all rows in users table
		$countusers = $users->countAll(); 

		// count all active user in the last 30 days
		$newusers = $users->like("created_at", $ym)->countAllResults(); 

		// count all active users
		$activeusers = $users->where('active', 1)->countAllResults(); 

		
		
		// load the view with session data
		return view('auth/admins/users', [
				'userData' => $this->session->userData, 
				'data' => $allusers, 
				'usercount' => $countusers, 
				'newusers' => $newusers,
				'activeusers' => $activeusers
			]);
	}

	public function enable()
	{
		// get the user id
		$id = $this->request->uri->getSegment(3);

		$users = new UserModel();

		$user = [
			'id'  	=> $id,
			'active'  	=> 1,
		];

		if (! $users->save($user)) {
			return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        return redirect()->back()->with('success', 'User enabled Successfully');
	}

	public function edit()
	{
		// get the user id
		$id = $this->request->uri->getSegment(3);

		// load user model
		$users = new UserModel();

		// get user data using the id
		$user = $users->where('id', $id)->first(); 

		// load the view with session data
		return view('auth/admins/edit-user', [
				'userData' => $this->session->userData, 
				'user' => $user, 
			]);
	}

	public function update()
	{
		$rules = [
			'id'	=> 'required|is_natural',
			'firstname'	=> 'required|alpha_space|min_length[2]',
			'lastname'	=> 'required|alpha_space|min_length[2]',
			'email'	=> 'required|valid_email|is_unique[users.email,id,{id}]',
			'active'	=> 'required|integer',
			'role'	=> 'required|integer',
		];

		if (! $this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$users = new UserModel();

		$user = [
			'id'  	=> $this->request->getPost('id'),
			'firstname' 	=> $this->request->getPost('firstname'),
			'lastname' 	=> $this->request->getPost('lastname'),
			'email' 	=> $this->request->getPost('email'),
			'active' 	=> $this->request->getPost('active'),
			'role' 	=> $this->request->getPost('role')

		];

		if (! $users->save($user)) {
			return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        return redirect()->back()->with('success', 'User Updated Successfully');
	}

	public function delete()
	{
		// get the user id
		$id = $this->request->uri->getSegment(3);

		// load user model
		$users = new UserModel();

		// delete user using the id
		$users->delete($id);

        return redirect()->back()->with('success', 'Account Deleted');
	}

	public function createUser()
	{
		helper('text');

		// save new user, validation happens in the model
		$users = new UserModel();
		$getRule = $users->getRule('registration');
		$users->setValidationRules($getRule);
		
        $user = [
            'firstname'          	=> $this->request->getPost('firstname'),
            'lastname'          	=> $this->request->getPost('lastname'),
            'email'         	=> $this->request->getPost('email'),
            'password'     		=> $this->request->getPost('password'),
            'password_confirm'	=> $this->request->getPost('password_confirm'),
            'activate_hash' 	=> random_string('alnum', 32)
        ];

        if (! $users->save($user)) {
			return redirect()->back()->withInput()->with('errors', $users->errors());
        }

		// send activation email //
		// send email activation is commented no email support //
		

		// success
        return redirect()->back()->with('success', 'Success! You created a new account');
	}

	public function userLogs() 
	{
		// load logs model
		$logs = new LogsModel();
		// get all user logs
		$userlogs = $logs->findAll();

		return view('auth/admins/user-logs', ['userData' => $this->session->userData, 'data' => $userlogs]);
	}

}
