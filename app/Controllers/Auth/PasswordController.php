<?php
namespace App\Controllers\Auth;

use CodeIgniter\Controller;
use Config\Email;
use Config\Services;
use App\Models\UserModel;

class PasswordController extends Controller
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
		
		$email = \Config\Services::email();
	}

    //--------------------------------------------------------------------

    public function forgotPassword()
	{
		if ($this->session->isLoggedIn) {
			return redirect()->to('account');
		}

		return view('auth/auth/forgot');
	}

    //--------------------------------------------------------------------

	public function attemptForgotPassword()
	{
		
		// validate request
		if (! $this->validate(['email' => 'required|valid_email'])) {
            return redirect()->back()->with('error', 'wrong Password');
        }

		// check if email exists in DB
		$users = new UserModel();

		$user = $users->where('email', $this->request->getPost('email'))->first();

		
		if (! $user) {
            return redirect()->back()->with('error', 'Email Not found in our records');
        }

        // check if email is already sent to prevent spam
        if (! empty($user['reset_expires']) && $user['reset_expires'] >= time()) {
			return redirect()->back()->with('error', 'Link already sent to your email');
        }

		// set reset hash and expiration
		helper('text');
		$updatedUser['id'] = $user['id'];
		$updatedUser['reset_hash'] = random_string('alnum', 32);
		$updatedUser['reset_expires'] = time() + HOUR;
		$users->save($updatedUser);
		// send password reset e-mail
		helper('auth');

        $sendMail=send_password_reset_email($this->request->getPost('email'), $updatedUser['reset_hash']);
        //Check if the mail link was not sent 
        if(!$sendMail){

        	return redirect()->back()->with('error', 'Something went wrong sending your activation link. Sorry for the inconvient.');

        }

        return redirect()->back()->with('success', 'An e-mail with instructions is sent to the address!');
	}

    //--------------------------------------------------------------------

	public function resetPassword()
	{
		// check reset hash and expiration
		$users = new UserModel();

		$user = $users->where('reset_hash', $this->request->getGet('token'))
			->where('reset_expires >', time())
			->first();

		if (! $user) {
            return redirect()->to('login')->with('error', 'Invalid Request');
        }

		return view('auth/auth/reset');
	}

    //--------------------------------------------------------------------

	public function attemptResetPassword()
	{
		// validate request
		$rules = [
			'token'	=> 'required',
			'password' => 'required|min_length[5]',
			'password_confirm' => 'matches[password]'
		];

		if (! $this->validate($rules)) {
            return redirect()->back()->with('error', 'Password Mismatched');
        }

		// check reset hash, expiration
		$users = new UserModel();
		
		$user = $users->where('reset_hash', $this->request->getPost('token'))
			->where('reset_expires >', time())
			->first();

		if (! $user) {
            return redirect()->to('login')->with('error', 'Invalid Request');
        }

		// update user password
        $updatedUser['id'] = $user['id'];
        $updatedUser['password'] = $this->request->getPost('password');
        $updatedUser['reset_hash'] = null;
        $updatedUser['reset_expires'] = null;
        $users->save($updatedUser);

		// redirect to login
        return redirect()->to('login')->with('success', 'Password updated successfully');

	}

}
