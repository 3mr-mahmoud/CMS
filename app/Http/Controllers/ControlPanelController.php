<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControlPanelController extends Controller
{
    public function enter() {
		  if (Auth::check()) {
			return view('control.index');  
	   } else {
		   return redirect('/control-panel/login'); 
		}
	}
}
