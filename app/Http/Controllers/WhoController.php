<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meta;
use Illuminate\Support\Facades\Auth;

class WhoController extends Controller
{
	
	
	
    public function index() {
		if(Auth::check()){
		$text = Meta::where('property','text')->where('page','who')->get();
		$years = Meta::where('property','LIKE','y%')->where('property','regexp','[0-9]')->orderBy('property','desc')->get();
		return view('control.who',['text' => $text, 'years' => $years]);
		} else {
			return redirect('/control-panel/login');
		}
	}
	
	
	
	public function eachindex($setedyear) {
		if(Auth::check()){
		$year = Meta::where('property','LIKE','%'.$setedyear)->get();
		return view('control.whoupdate',['year' => $year]);
		} else {
		return redirect('/control-panel/login');
		}
	}
	
	
	
	
	public function store() {
		if(Auth::check()) {
			$this->validate(request(),[
			'year' => 'required|numeric',
			'text' => 'required|min:6'
		]);
		Meta::create([
		'property' => 'y'.request('year'),
		'data' => request('text'),
		'page' => 'who'
		]);
		return redirect('/control-panel/who?success=1');
		} else {
			return redirect('/control-panel/login');
		}
	}
	
	
	
	public function update() {
		if(Auth::check()) {
			$this->validate(request(),[
			'text' => 'required|min:6'
		]);
		Meta::where('property','text')->where('page','who')->update(['data' => request('text')]);
		return redirect('/control-panel/who?success=1');
		} else {
			return redirect('/control-panel/login');
		}
	}
	
	
	
	public function eachupdate(Request $request,$property) {
		if(Auth::check()){
			$this->validate(request(),[
			'year' => 'required|numeric',
			'text' => 'required|min:6'
		]);
		Meta::where('property','LIKE','%'.$property)->update(['property' => 'y'.request('year'), 'data' => request('text')]);
		return redirect('/control-panel/who/'.request('year').'/update?success');
		} else {
			return redirect('/control-panel/login');
		}
	}
	
	public function form() {
		if(Auth::check()){
			return view('control.whoadd');
		}
	}
	
	public function delete($property){
		if(Auth::check()) {
			if(Meta::where('property','LIKE','%'.$property)->count() > 0){
			Meta::where('property','LIKE','%'.$property)->delete();
			return redirect('/control-panel/who?delete=1');
			} else {
				$message = array("البيانات المطلوبة غير متوفرة");
				$title = array('404 Not Found');
				$back = array('/control-panel/who');
				return view('control.messages',compact('message','title','back'));
			}
		} else {
			return redirect('/control-panel/login');
		}
	}
}
