<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;


class Reply extends Model
{
    //
     protected $guarded = [];

    protected $with     = ['owner'];

    protected $fillable = ["body", "user_id", "thread_id"];

  

    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }



    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function path()

    {
        return '/replies/' . $this->id;
    }



  



}
