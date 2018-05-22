<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\User;

class UserController extends Controller
{
	public function __construct() {
		$this->middleware('can:view,App\User')->except(['update','edit']);
	}
	public function index() {
		$data = User::select('id','name','created_at','email','permission')->
		where('id','!=',auth()->user()->id)->
		get();

		if(request()->expectsJson()) return  response()->json(['data' => $data->toArray()]);
			return view('control.users.index');
	}
	
    public function show() {
		return view('control.users.add');
	}
	
	public function store() {
		$this->validate(request(), [
			'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|min:6|confirmed'
		]);
		$inputs = request()->only(['name','email','username','password','permission']);
		$inputs['password'] = bcrypt($inputs['password']);
		User::create($inputs);
		return redirect()->route('user-home')->withFlash(__('messages.success'));
	}
	public function edit(User $user) {
		$user->can('update');
		return view('control.users.update',['data'=>$user]);
	}
	public function update(User $user) {
		$user->can('update');
		$this->validate(request(), [
			'name' => 'required|string|max:255',
            'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($user->email,'email')],
            'username' => ['required','string',Rule::unique('users')->ignore($user->username,'username')],
            'permission' => 'integer|min:0|max:1'
		]);
		if(request('password') !== null) $user->password = bcrypt(request('password'));	
		$user->name = request('name');
		$user->username = request('username');
		$user->email = request('email');
		if(request('password') !== null) $user->permission = request('permission');
		if($user->save()){ 
			if(request()->expectsJson()) return __('messages.updated');
			return back()->withFlash(__('messages.updated'));
		}
	}
	
	public function destroy(User $user) {
			$user->delete();
			return __('messages.deleted');
	}
	
	public function admin(User $user) {
			$user->update(['permission' => 1]);
			return __('messages.success');
	}
	
}
