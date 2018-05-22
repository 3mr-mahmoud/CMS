<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meta;
use Illuminate\Support\Facades\Auth;

class HomePage extends Controller
{
    public function index() {
		return view('control.home');
	}
	
	public function update() {
		return request();
	}
}
