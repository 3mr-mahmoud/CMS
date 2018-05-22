<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VisitorOpinion;

class OpinionController extends Controller
{
	public function __construct(){
		$this->middleware('auth')->except('store');
	} 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VisitorOpinion $opinion)
    {
        $opinions = $opinion->all();
		return view('control.opinionindex',compact('opinions'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
			'name' => 'required|max:40|min:3',
			'email' => 'required|max:60|min:10',
			'questions1' => 'required|integer|between:1,5',
			'questions2' => 'required|integer|between:1,5',
			'questions3' => 'required|integer|between:1,5',
			'questions4' => 'required|integer|between:1,5',
			'questions5' => 'required|integer|between:1,5'
		]);
		
		$requests = ['name','email','questions1','questions2','questions3','questions4','questions5'];
		
        $opinion = VisitorOpinion::create([
            'name' => request($requests[0]),
            'email' => request($requests[1]),
            'q1' => request($requests[2]),
            'q2' => request($requests[3]),
            'q3' => request($requests[4]),
            'q4' => request($requests[5]),
            'q5' => request($requests[6])
        ]);

        return back()->with('success','تم استلام بيناتاك بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Opinion  $opinion
     * @return \Illuminate\Http\Response
     */
    public function show(Opinion $opinion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Opinion  $opinion
     * @return \Illuminate\Http\Response
     */
    public function edit(Opinion $opinion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Opinion  $opinion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Opinion $opinion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Opinion  $opinion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Opinion $opinion)
    {
        //
    }
}
