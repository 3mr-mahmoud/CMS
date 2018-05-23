<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function __construct() {
		$this->middleware('guest',['except'=>'logout']);
	}
    public function index() {  
		   return view('control.login'); 
	}
	
	public function login() {
		$this->validate(request(), [
			'password' => 'required',
			'email' => 'required|email'
		]);
			$credentials = [
			'email' => request('email'),
            'password' => request('password'),
        ];
        $remember = false;
        if(request('remember')) $remember = true;
		if(Auth::attempt($credentials, $remember)) {
			return redirect()->intended(request()->segment(1).'/control-panel');
		} else {
			$errors = collect([__('messages.loginFail')]);
			return back()->withErrors($errors); 
		}
	}
	public function logout(){
		Auth::logout();
			return redirect()->route('loginPage');
	} 	
}