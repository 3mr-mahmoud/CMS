<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Article $article)
    {
       $data = $article->all();
      if(request()->expectsJson()) return  response()->json(['data' => $data->toArray()]);
	   return view('control.articles.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('control.articles.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Article $article)
    {
    $this->doValidation($article);
    $inputs = $request->only($article->fields);
    $inputs['user_id'] = auth()->user()->id;
	if(Article::create($inputs)) return redirect($article->path())->withFlash(__('messages.added'));
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
        return view('control.articles.update',['data'=> $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $articles
     * @return \Illuminate\Http\Response
     */
    public function update(Article $article,Request $request)
    {
	$this->validate(request(), [
		'title' => 'required|min:5|max:600',
        'keywords'=>'required',
		'keywords.*' => 'min:2|max:30',
		'description' => 'required|min:3|max:600',
		'body' => 'required|min:20'
	]);
    $inputs = $request->only($article->fields);

    $article->update($inputs);
    if(request()->expectsJson()) return __('messages.updated');
	return redirect($article->path());
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
            return __('messages.deleted');
    }
}
