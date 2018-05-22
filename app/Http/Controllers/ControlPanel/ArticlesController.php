<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
	public function __construct() {
		$this->middleware('auth',['except'=>['show','showeach']]);
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Article $article)
    {
       $data = $article->all();
	   return view('control.articleindex',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('control.articleadd');
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
		'body' => 'required|min:20'
	]);
	Article::create([
	'title' => request('title'),
	'keywords' => request('keywords'),
	'description' => request('des'),
	'body' => request('body')
	]);
	return redirect('/control-panel/articles?success=1');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $articles
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
       $data = $article->all();
	   return view('articleindex',compact('data'));
    }
	
	public function showeach(Article $article)
    {
	   return view('article',['data'=> $article]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $articles
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
		return view('control.articleupdate',['data'=> $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $articles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
	$this->validate(request(), [
		'title' => 'required|min:5|max:600',
		'keywords.*' => 'required|min:2|max:30',
		'description' => 'required|min:3|max:600',
		'body' => 'required|min:20'
	]);
    $inputs = request()->intersect($article->getTableColumns());

    $article->update($inputs);	
	return redirect('/control-panel/articles?success=1');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $articles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
			$article->delete(); 
            return 'تم الحذف بنجاح';
    }

}
