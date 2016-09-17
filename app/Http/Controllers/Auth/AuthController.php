<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:55|regex:/(^[A-Za-z ]+$)+/',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'birthday' => 'required|date',
            'gender' => 'required',
            'phone' => 'required|max:14|regex:/(^[0-9+]+$)+/',
        ]);
    }

    public function getLogin(){
        // Do your custom login magic here.
        return "you r logged in";
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        \Session::flash('flash_message','Registered Successfully.');
        \Session::flash('new_reg','Registered Successfully.');
       
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => md5($data['password']),
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'phone' => $data['phone']
        ]);
        return redirect('login');

    }
}
