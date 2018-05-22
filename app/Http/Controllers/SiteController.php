<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meta;
use App\Home;

class SiteController extends Controller
{
    public function home(Home $home, Meta $meta) {
		$firstsec1 = $meta->home('firstsec')->get();
		$homeData = $home->all();
		$firstsec2 = $homeData->where('section','first')->first();
		$secondsec = $homeData->where('section','second')->first();
		$thirdsec = $homeData->where('section','third')->first();
		return view('home',compact('firstsec1','firstsec2','secondsec','thirdsec'));
	}
	public function opinion() {
		return view('opinion');
	}
	public function contact(Meta $meta) {
		$tel = $meta->where('page','contact')->where('property','tel')->get();
		$map = $meta->where('page','contact')->where('property','map')->get();
		$email = $meta->where('page','contact')->where('property','email')->get();
		$address = $meta->where('page','contact')->where('property','address')->get();
		return view('contact',compact('tel','email','address','map'));
	}
	public function protofolio(\App\Album $albums) {
		$data = $albums->distinct()->select('title')->get();
		$images = $albums->all();
		return view('protofolio',compact('data','images'));
	}
	
	public function who(Meta $meta) {
		$text = $meta->where('page','who')->where('property','text')->get();
		$years = $meta->where('page','who')->where('property','LIKE','y%')->where('property','regexp','[0-9]')->orderBy('property','desc')->get();
		return view('story',compact('text','years'));
	}
	
	public function search(\App\Article $articles, \App\Product $products, \App\Category $categs) {
		$term = $_GET['q'];
		if(!empty($term)) {
		$data1 = $articles->where('title','LIKE','%'.$term.'%')->orWhere('description','LIKE','%'.$term.'%')->orWhere('keywords','LIKE','%'.$term.'%')->get();
		$data2 = $products->where('name','LIKE','%'.$term.'%')->orWhere('description','LIKE','%'.$term.'%')->orWhere('keywords','LIKE','%'.$term.'%')->get();
		$data3 = $categs->all();
		return view('search',compact('data1','data2','data3'));
		}
	}
	
}
