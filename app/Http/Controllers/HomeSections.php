<?php

namespace App\Http\Controllers;

use App\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class HomeSections extends Controller
{
    public function index() {
		if(Auth::check()) {
			$firstsec = Home::where('section','first')->get();
			$secondsec = Home::where('section','second')->get();
			$thirdsec = Home::where('section','third')->get();
			return view('control.homesections',compact('firstsec','secondsec','thirdsec'));
		} else {
			return redirect('/control-panel/login');
		}
	}
	
	public function update(Request $request) {
		if(Auth::check()) {
			$this->validate(request(),[
			'title1','title2','title3' => 'required|min:4|max:60',
			'des1','des2','des3' => 'required|min:4|max:200',
			'btn1','btn2','btn3' => 'required|min:4|max:60',
			'image1','image2','image3' => 'image'
		]);
		Home::where('section','first')->update(['title' => request('title1'),'description' => request('des1'),'btn' => request('btn1')]);
		Home::where('section','second')->update(['title' => request('title2'),'description' => request('des2'),'btn' => request('btn2')]);
		Home::where('section','third')->update(['title' => request('title3'),'description' => request('des3'),'btn' => request('btn3')]);
		$destinationPath = base_path() . '\public\images';
		if($request->hasFile('firstimage')){
			$firstfile = $request->file('firstimage');
			$firstname = $firstfile->getClientOriginalName();
			$firstfile->move($destinationPath, $firstname);
			Home::where('section','first')->update(['image' => 'images/'.$firstname ]);
		}
		
		if($request->hasFile('secondimage')){
			$secondfile = $request->file('secondimage');
			$secondname = $secondfile->getClientOriginalName();
			$secondfile->move($destinationPath, $secondname);
			Home::where('section','second')->update(['image' => 'images/'.$secondname ]);
		}
		
		if($request->hasFile('thirdimage')){
			$thirdfile = $request->file('thirdimage');
			$thirdname = $thirdfile->getClientOriginalName();
			$thirdfile->move($destinationPath, $thirdname);
			Home::where('section','third')->update(['image' => 'images/'.$thirdname ]);
		}
		return redirect('/control-panel/homesections?success=1');
		} else {
			return redirect('/control-panel/login');
		}
	}
}
