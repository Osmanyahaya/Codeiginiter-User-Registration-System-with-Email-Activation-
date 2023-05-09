<?php
namespace App\Controllers\Auth;

use CodeIgniter\Controller;
use Config\Email;
use Config\Services;
use App\Models\UserModel;

class RegistrationController extends Controller
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
	 * Displays register form.
	 */
	public function register()
	{
		if ($this->session->isLoggedIn) {
			return redirect()->to('account');
		}

		return view('auth/register');
	}

    //--------------------------------------------------------------------

	/**
	 * Attempt to register a new user.
	 */
	public function attemptRegister()
	{
		$users = new UserModel();
		helper(['text','form']);
		$validated=$this->validate([
			'firstname' 		=> 'required|alpha_space|min_length[2]',
			'lastname' 			=> 'required|alpha_space|min_length[2]',
			'email' 			=> 'required|valid_email|is_unique[users.email,id,{id}]',
			'password'			=> 'required|min_length[8]|max_length[20]',
			'password_confirm'	=> 'matches[password]'
		]
	);
		

        if (!$validated) {
       	
        	return view('auth/register',['errors'=>$this->validator]);
        }
  
        	$user = [
            'firstname'          	=> $this->request->getPost('firstname'),
            'lastname'          	=> $this->request->getPost('lastname'),
            'email'         	=> $this->request->getPost('email'),
            'password'     		=> $this->request->getPost('password'),
            'password_confirm'	=> $this->request->getPost('password_confirm'),
            'activate_hash' 	=> random_string('alnum', 32)
        	];
        	// save user
        	$users->save($user);
        	// send activation email //
        	 helper('auth'); 
       		 $sendMail=send_activation_email($user['email'], $user['activate_hash']);

        		if(!$sendMail){

        		return redirect()->back()->with('error', 'Something went wrong sending your activation link. Sorry for the inconvient.');
        	 
        		}


         return redirect()->to('login')->with('success', "Registration was successfully, activation link sent to your email");

		
		
		

		
	}

    //--------------------------------------------------------------------

	/**
	 * Activate account.
	 */
	public function activateAccount()
	{
		$users = new UserModel();

		// check token
		$user = $users->where('activate_hash', $this->request->getGet('token'))
			->where('active', 0)
			->first();

		// check user if exists
		if (is_null($user)) {
			return redirect()->to('login')->with('error', 'There is no user with this activation code.');
		}

		// update user account to active
		$updatedUser['id'] = $user['id'];
		$updatedUser['active'] = 1;
		$users->save($updatedUser);

		return redirect()->to('login')->with('success', 'Successful activation! Now you can login to your account!');
	}

}
