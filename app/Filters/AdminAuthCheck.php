<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthCheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
     if(session()->get('userData.role')!='1')

     //dd(session()->get('isLoggedIn')); 
      return redirect()->to('account')->withInput()->with('error', 'You Cannot do this!!!'); 
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
        //if(!session()->get('userData.role')=='1')
    }
}