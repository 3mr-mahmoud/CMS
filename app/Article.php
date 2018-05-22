<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	public $fields = ['locale','active','title','description','meta_description','keywords','body'];
	protected $guarded = [];
	public $rules = [
		'title' => 'required|min:5|max:600',
        'keywords'=>'required',
		'keywords.*' => 'min:2|max:30',
		'description' => 'required|min:3|max:600',
		'meta_description' => 'required|min:3|max:300',
		'body' => 'required|min:20',
		'active' => 'required|integer|min:0|max:1'
	];
	protected $casts = ['keywords' => 'array'];
	public function setKeywordsAttribute($value)
	{
		$this->attributes['keywords'] = json_encode($value);
	}

}
