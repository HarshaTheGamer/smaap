<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;
use DB;
use App\friends;
use App\Zone;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Mail;


class AuthController extends Controller {

	public function handleregister(Request $request) {
		$validator = Validator::make(Input::all(),User::$register_validation_rules);
        if($validator->fails()){

          return back()->withInput()->withErrors($validator);
    	}
       
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => md5($request['password']),
            'birthday' => $request['birthday'],
            'gender' => $request['gender'],
            'phone' => $request['phone']
        ]);
        if($this->verify($request->email)) {
        	\Session::flash('flash_message','Successfully registered!!!!, Please check your email to verify in order to login.');
    		return redirect('login');
        }
        else {
        	return "unexpected error";
        }
       
	}

	public function verify($email) {
		$code = mt_rand(100000,999999);
	    Mail::send('auth.emails.verify', ['email' => $email, 'code' => $code], function ($m) use ($email) {
	            $m->from('harsha.m.n1993@gmail.com', 'smaap');

	            $m->to($email, NULL)->subject('Verify email!');
	        });
	    return User::where('email',$email)->update(array('confirmation_code'=>$code));
	}

}