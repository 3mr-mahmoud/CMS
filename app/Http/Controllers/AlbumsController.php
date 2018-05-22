<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use Image;
use Validator;
use Illuminate\Support\Facades\Storage;

class AlbumsController extends Controller
{
    
	public function __construct() {
		$this->middleware('auth');
	}
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::distinct()->select('title')->get();
		return view('control.albumindex',compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('control.albumadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			
	 
		
		$this->validate(request(),[
		'title' => 'required|min:3|max:200',
		'images.*' => 'image|mimes:jpeg,png|max:2000'
	]);
	
	$picture = '';
if ($request->hasFile('images')) {
    $files = $request->file('images');
    foreach($files as $file){
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $picture = date('Ymd').$filename;
        $destinationPath = base_path() . '/public/images/';
		$destinationPath2 = base_path() . '/public/thumbs/';
		Image::make($file->getRealPath())->resize(300, 250)->save($destinationPath2.$picture);
        $file->move($destinationPath, $picture);
		Album::create([
		'title' => request('title'),
		'image' => 'images/'.$picture,
		'thumb' => 'thumbs/'.$picture
	]);
    }
	return redirect('/control-panel/album/add?success');
}
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Album  $albums
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $albums, $title)
    {
		$filtertitle = str_replace('-',' ',$title);
        $oldalbums = $albums->where('title',$filtertitle)->get();
		if(count($oldalbums) > 0) {
			$oldtitle  = $albums->where('title',$filtertitle)->distinct()->select('title')->get();
			return view('control.albumupdate',compact('oldalbums','oldtitle'));
		} else {
			$message = array("لم نجد أى بيانات تطابق ما");
			$title = array("Whoops | 404 Not Found");
			$back = array("/control-panel/album");
			return view('control.messages',compact('message','title','back'));
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Album  $albums
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $albums, $title)
    {
     $filtertitle = str_replace('-',' ',$title);
     $checkalbums = $albums->where('title',$filtertitle)->get();
	 if(count($checkalbums) > 0) {
		 if ($request->hasFile('images')) {
			 $this->validate(request(),[
		'title' => 'required|min:3|max:200',
		'images.*' => 'image|mimes:jpeg,png|max:2000'
	]);
	 } else {
		 $this->validate(request(),['title' => 'required|min:3|max:200']);
	}
		 if ($request->hasFile('images')) {
    $files = $request->file('images');
    foreach($files as $file){
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $picture = date('Ymd').$filename;
        $destinationPath = base_path() . '/public/images/';
		$destinationPath2 = base_path() . '/public/thumbs/';
		Image::make($file->getRealPath())->resize(300, 250)->save($destinationPath2.$picture);
        $file->move($destinationPath, $picture);
		Album::create([
		'title' => $filtertitle,
		'image' => 'images/'.$picture,
		'thumb' => 'thumbs/'.$picture
	]);
    }
	
	 }
	  $albums->where('title',$filtertitle)->update(['title' => request('title')]);
	  return redirect('/control-panel/album/'.str_replace(' ','-',request('title')).'/update?success');
	 } else {
		 	$message = array("لم نجد أى بيانات تطابق ما");
			$title = array("Whoops | 404 Not Found");
			$back = array("/control-panel/album");
			return view('control.messages',compact('message','title','back'));
	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Album  $albums
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $albums, $title)
    {
     $filtertitle = str_replace('-',' ',$title);
     $checkalbums = $albums->where('title',$filtertitle)->get();
	 if(count($checkalbums) > 0) {
		foreach($checkalbums as $album ){
			if(is_writable($album->image) && is_writable($album->thumb)) {
			 unlink($album->image);
			 unlink($album->thumb);
			}
		}
		$albums->where('title',$filtertitle)->delete();
		return redirect('/control-panel/album?delete=1');
	} else {
		$message = array("لم نجد أى بيانات تطابق ما");
			$title = array("Whoops | 404 Not Found");
			$back = array("/control-panel/album");
			return view('control.messages',compact('message','title','back'));
	}
    }
	
	public function destroy2(Album $albums, $image, $title)
    {
         $filtertitle = str_replace('-',' ',$title);
     $checkalbums = $albums->where('title',$filtertitle)->where('image','images/'.$image)->get();
	 if(count($checkalbums) > 0) {
		$albums->where('title',$filtertitle)->where('image','images/'.$image)->delete();
		unlink('images/'.$image);
		unlink('thumbs/'.$image);
			return 'تم الحذف';
	} else {
		$message = array("لم نجد أى بيانات تطابق ما طلبته");
			$title = array("Whoops | 404 Not Found");
			$back = array("/control-panel/album");
			return view('control.messages',compact('message','title','back'));
	}
    }
	
	
}
