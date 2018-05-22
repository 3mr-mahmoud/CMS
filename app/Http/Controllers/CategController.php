<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Image;

class CategController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $categ)
    {
        $data = $categ->all();
		return view('control.categindex',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('control.categadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
		'title' => 'required|min:5|max:600',
		'keywords.*' => 'required|min:2|max:30',
		'des' => 'required|min:3|max:600',
		'image' => 'required|image|mimes:jpeg,png|max:2000'
	]);
	if(count(request('keywords')) > 0 ) {
		$keywords  = serialize(request('keywords'));
	}
	$file = $request->file('image');
	    $filename = $file->getClientOriginalName();
        $picture = date('His').$filename;
		$destinationPath2 = base_path() . '/public/thumbs/';
		Image::make($file->getRealPath())->resize(150, 150)->save($destinationPath2.$picture);
	Category::create([
	'title' => request('title'),
	'keywords' => $keywords,
	'description' => request('des'),
	'thumb' => 'thumbs/'.$picture
	]);
	return redirect('/control-panel/categs?success=1');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $categ
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $categ
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, $id)
    {
        if(is_numeric($id)) {
        $categoryg = $category->where('id',$id);
		$count = count($categoryg->get());
		if($count > 0 ) {
			$data = $categg->get();
			$data2 = $categg->select('keywords')->get();
			$keywords = unserialize($data2[0]->keywords);
			return view('control.categupdate',compact('data','keywords'));
		}
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $categ
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $categ, $id)
    {
	 if(is_numeric($id)) {
			$this->validate(request(), [
		'title' => 'required|min:5|max:600',
		'keywords.*' => 'required|min:2|max:30',
		'des' => 'required|min:3|max:600',
		'image' => 'image|mimes:jpeg,png|max:2000'
	]);
        $categg = $categ->where('id',$id);
		$count = count($categg->get());
		if($count > 0 ) {
			if(count(request('keywords')) > 0 ) {
		$keywords  = serialize(request('keywords'));
	}
	$file = $request->file('image');
	if ($request->hasFile('image')) {
		$oldimage = $categg->select('thumb')->get();
		unlink($oldimage[0]->thumb);
	    $filename = $file->getClientOriginalName();
        $picture = date('His').$filename;
		$destinationPath2 = base_path() . '/public/thumbs/';
		Image::make($file->getRealPath())->resize(150, 150)->save($destinationPath2.$picture);
		$categg->update(['thumb' => 'thumbs/'.$picture]);
	}
	$categg->update([
	'title' => request('title'),
	'keywords' => $keywords,
	'description' => request('des')
	]);		
	return redirect('/control-panel/categs?success=1');
		}
		}
 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $categ
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $categ, $id)
    {
        $categg = $categ->where('id',$id);
        $count = count($categg->get());
		if($count > 0) {
			$oldimage = $categg->select('thumb')->get();
		    unlink($oldimage[0]->thumb);
			$categg->delete();
			return 'تم الحذف بنجاح';
		} else {
			redirect('/404');
		}
    }
}
