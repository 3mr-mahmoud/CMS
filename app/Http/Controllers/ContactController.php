<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\contact;
use App\Meta;

class ContactController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
	
	
    public function index1(Meta $meta) {
		$tel = $meta->where('property','tel')->where('page','contact')->get();
		$map = $meta->where('property','map')->where('page','contact')->get();
		$address = $meta->where('property','address')->where('page','contact')->get();
		$email = $meta->where('property','email')->where('page','contact')->get();
		return view('control.contactupdate',compact('tel','map','address','email'));
	}
	
	
	
	
	public function index2(contact $contact) {
		$messages = $contact->all();
		return view('control.contactmessages',compact('messages'));
	}
	
	
	public function index3(contact $contact,$id) {
		$messages = $contact->where('id',$id)->get();
		$count = count($messages);
		if( $count > 0 && is_numeric($id)) {
			return view('control.contactmessage',compact('messages'));
		} else {
			$message = array("لم نجد أى بيانات تطابق ما");
			$title = array("Whoops | 404 Not Found");
			$back = array("/control-panel/contact/messages");
			return view('control.messages',compact('message','title','back'));
		}
	}
	
	public function delete(contact $contact,$id) {
		$count  = count($contact->where('id',$id)->get());
		if($count > 0) {
			$contact->where('id',$id)->delete();
			return 'تم الحذف بنجاح';
		} else {
		$message = array("لم نجد أى بيانات تطابق ما");
			$title = array("Whoops | 404 Not Found");
			$back = array("/control-panel/contact/messages");
			return view('control.messages',compact('message','title','back'));
	}
	}
	
	
	public function update(Meta $meta,Request $request) {
		$this->validate(request(), [
			'map' => 'required|min:3|url',
			'email' => 'required|max:100|min:8|email',
			'tel' => 'required|max:13|min:11',
			'address' => 'required|max:400',
		]);
		$meta->where('property','tel')->where('page','contact')->update(['data' => request('tel')]);
		$meta->where('property','map')->where('page','contact')->update(['data' => request('map')]);
	$meta->where('property','address')->where('page','contact')->update(['data' => request('address')]);
		$meta->where('property','email')->where('page','contact')->update(['data' => request('email')]);
		return redirect('/control-panel/contact?success=1');
	}
}
