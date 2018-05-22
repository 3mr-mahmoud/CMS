<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\contact;

class Conta extends Controller
{
     public function store() {
		
		$this->validate(request(), [
			'name' => 'required|max:30|min:3',
			'email' => 'required|max:60|min:8|email',
			'phone' => 'required|max:11|min:11',
			'subject' => 'required|min:4|max:200',
			'body' => 'required|min:4|max:1000'
		]);
		
		$requests = array('name','email','phone','subject','body');
		contact::create([
			'name' => request($requests[0]),
			'email' => request($requests[1]),
			'phone' => request($requests[2]),
			'subject' => request($requests[3]),
			'body' => request($requests[4])
		]);
		 if(empty($errors)) {
		$message = array("تم استلام بيناتاك بنجاح");
		}
		return view('contact',compact('message'));
	}
}
