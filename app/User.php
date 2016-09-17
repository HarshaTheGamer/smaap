<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birthday', 'gender', 'phone', 'created_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $login_validation_rules = [
        'email' => 'required|email|exists:users',
        'password' => 'required'
    ];
    public static $register_validation_rules = [
            'name' => 'required|max:55|regex:/(^[A-Za-z ]+$)+/',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'birthday' => 'required|date',
            'gender' => 'required',
            'phone' => 'required|max:14|regex:/(^[0-9+]+$)+/',
    ];

    public static $email_validation_rules = [
        'email' => 'required|email|exists:users'
    ];
     public static $email_rules = [
        'email' => 'required|email|min:8'
    ];

    public static $name_rules = [
        'name' => 'required|max:55|regex:/(^[A-Za-z ]+$)+/'
    ];
}
