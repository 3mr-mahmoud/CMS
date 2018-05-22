<?php

namespace App\Http\Controllers;

use App\Product;
use App\attachment;
use App\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function __construct() {
	     $this->middleware('auth',['except'=>['show','showcateg','showeach']]);
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data  = Product::paginate(20);
		return view('control.productindex',compact('data'));
    }
	
	public function search() {
		$term = $_GET['search'];
		$data  = Product::where('name','like','%'.$term.'%')->paginate(20);
		return view('control.productindex',compact('data'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$categs = Category::all();
        return view('control.productadd',compact('categs'));
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
		'name' => 'required|min:2|max:200|unique:products,name',
		'des' => 'required|min:2|max:160',
		'categ' => 'required|integer',
		'keywords.*' => 'required|min:2|max:50',
		'body' => 'required|min:2',
		'image' => 'required|max:2000',
		'files.*' => 'file',
		'extlink' => 'required|url'
		]);
		if($request->hasFile('files')) {
			$files = $request->file('files');
			foreach($files as $file){
				$type = $file->getClientOriginalExtension();
				$filename = $file->getClientOriginalExtension();
				$destinationPath = base_path() . '/public/files/';
				$file->move($destinationPath, $filename);
				attachment::create([
				'title' => request('name'),
				'path' => 'files/'.$filename
				]);
			}
		}
		if($request->hasFile('image')) {
			$image = $request->file('image');
			$type2 = $image->getClientOriginalExtension();
				$imagename = date('Ymd');
				$destinationPath2 = base_path() . '/public/images/';
				$image->move($destinationPath2, $imagename.'.'.$type2);
			Product::create([
			'name' => request('name'),
			'description' =>request('des'),
			'keywords' => serialize(request('keywords')),
			'body' => request('body'),
			'categ_id' => request('categ'),
			'image' => 'images/'.$imagename.'.'.$type2,
			'extlink' => request('extlink')
		]);
		return redirect('/control-panel/products?success');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Category $categ)
    {
        $data = $product->all();
		$data2 = $categ->all();
		return view('shop',compact('data','data2'));
    }
	
    public function showcateg(Product $product, Category $categ, $categterm)
    { 
		$term = str_replace('-',' ',$categterm);
		$category = $categ->where('title','like',$term)->get();
		if(count($category) > 0) {
        $data = $product->where('categ_id',$category[0]->id)->paginate('20');
		return view('shopcateg',compact('data','category'));
		} else {
			return redirect('/shop');
		}
    }
	
	public function showeach(Product $product, Category $categ, $categterm, $id)
    {
		$category = $categ->all();
		$data = $product->where('id',$id)->get();
		if(count($category) > 0 && count($data) > 0) {
		return view('shopproduct',compact('data','category'));
		} else {
			return redirect('/shop');
		}
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product,$id)
    {
        $productvar = $product->where('id',$id);
		$count = count($productvar->get());
		if ($count > 0 ){
			$data = $productvar->get();
			$data2 = attachment::where('title',$data[0]->name)->get();
			$categs = Category::all();
			$keywords = unserialize($data[0]->keywords);
			return view('control.productupdate',compact('data','data2','categs','keywords'));
		} else {
		  $message = array("لم نجد أى بيانات تطابق ما طلبت");
			$title = array("Whoops | 404 Not Found");
			$back = array("/control-panel/products");
			return view('control.messages',compact('message','title','back'));
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product,$id)
    {
        $this->validate(request(), [
		'name' => 'required|min:2|max:200',
		'des' => 'required|min:2|max:160',
		'categ' => 'required|integer',
		'keywords.*' => 'required|min:2|max:50',
		'body' => 'required|min:2',
		'image' => 'max:2000',
		'files.*' => 'file',
		'extlink' => 'required|url'
		]);
		$productvar = $product->where('id',$id);
		$count = count($productvar->get());
		$oldata = $productvar->get();
		if ($count > 0 ){
			if($request->hasFile('files')) {
			$files = $request->file('files');
			foreach($files as $file){
				$type = $file->getClientOriginalExtension();
				$filename = $file->getClientOriginalExtension();
				$destinationPath = base_path() . '/public/files/';
				$file->move($destinationPath, $filename);
				attachment::create([
				'title' => request('name'),
				'path' => 'files/'.$filename
				]);
			}
			}
			if($request->hasFile('image')) {
				$image = $request->file('image');
			    $type2 = $image->getClientOriginalExtension();
				$imagename = date('Ymd');
				$destinationPath2 = base_path() . '/public/images/';
				unlink($oldata[0]->image);
				$image->move($destinationPath2, $imagename.'.'.$type2);
				$productvar->update(['image' => 'images/'.$imagename.'.'.$type2]);
			}
			attachment::where('title',$oldata[0]->name)->update(['title' => request('name')]);
			$productvar->update([
			'name' => request('name'),
			'description' =>request('des'),
			'keywords' => serialize(request('keywords')),
			'body' => request('body'),
			'categ_id' => request('categ'),
			'extlink' => request('extlink')
		]);
			
			return redirect('/control-panel/products?success=1');
		} else {
		  $message = array("لم نجد أى بيانات تطابق ما طلبت");
			$title = array("Whoops | 404 Not Found");
			$back = array("/control-panel/products");
			return view('control.messages',compact('message','title','back'));
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,$id)
    {
        $productvar = $product->where('id',$id);
		$count = count($productvar->get());
		if ($count > 0 ){
			$data = $productvar->get();
			$attach = attachment::where('title',$data[0]->name)->select('path');
			$data2 = $attach->get();
			unlink($data[0]->image);
			foreach($data2 as $file) {
			unlink($file->path);
			}
			$productvar->delete();
			$attach->delete();
			return "تم الحذف بنجاح";
		} else {
		  $message = array("لم نجد أى بيانات تطابق ما طلبت");
			$title = array("Whoops | 404 Not Found");
			$back = array("/control-panel/products");
			return view('control.messages',compact('message','title','back'));
		}
    }
	public function destroy2($name) {
		
		$dir = "files/".$name;
		$attach = attachment::where('path',$dir)->select('path');
		$count = count($attach->get());
		if(is_writable($dir) && $count > 0) {
			unlink($dir);
			$attach->delete();
			return"تم الحذف بنجاح";
		} else {
			return "لم نجد ما طلبت";
		}
	}
	
	
	
	
	
}
