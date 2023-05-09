<?php

use Config\Services;

if (! function_exists('send_activation_email'))
{
    /**
    * Builds an account activation HTML email from views and sends it.
    */
    function send_activation_email($to, $activateHash)
    {
    	$htmlMessage = view('App\Views\auth\emails\header');
    	$htmlMessage .= view('App\Views\auth\emails\activation', ['hash' => $activateHash]);
    	$htmlMessage .= view('App\Views\auth\emails\footer');

    	$email = \Config\Services::email();
		$email->initialize([
			'mailType' => 'html'
		]);

    	$email->setTo($to);
        $email->setSubject('Registration');
		$email->setMessage($htmlMessage);

        if($email->send()){

          return true;
        }
        
    
    return false; 

        
   
        }
}




if (! function_exists('send_notification_email'))
{
    /**
    * Builds a notification HTML email about email address change from views and sends it.
    */
    function send_notification_email($to)
    {
        $htmlMessage = view('Views\emails\header');
        $htmlMessage .= view('Views\emails\notification');
        $htmlMessage .= view('Views\emails\footer');

        $email = \Config\Services::email();
        $email->initialize([
            'mailType' => 'html'
        ]);

        $email->setTo($to);
        $email->setSubject('Notification Email');
        $email->setMessage($htmlMessage);


        if (!$email->send()) {
        return false;

        }

       return true;
    }
}


if (! function_exists('send_password_reset_email'))
{
    /**
    * Builds a password reset HTML email from views and sends it.
    */
    function send_password_reset_email($to, $resetHash)
    {
        $htmlMessage = view('App\Views\auth\emails\header');
        $htmlMessage .= view('App\Views\auth\emails\reset', ['hash' => $resetHash]);
        $htmlMessage .= view('App\Views\auth\emails\footer');

        $email = \Config\Services::email();
        $email->initialize([
            'mailType' => 'html'
        ]);

        $email->setTo($to);
        $email->setSubject('Password Reset Request');
        $email->setMessage($htmlMessage);

        if (!$email->send()) {
        return false;

        }

       return true;
       

        
    }
}
