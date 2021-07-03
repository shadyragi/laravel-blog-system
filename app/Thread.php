<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\scopes\repliescountScope;

use Auth;

class Thread extends Model
{
    //

       protected $fillable = ['title', 'body', 'user_id', 'channel_id'];

    protected $with     = ['owner', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new repliescountScope);
        /*static::addGlobalScope('repliescount', function($builder) {
            return $builder->withCount('replies');
        });*/

        static::deleting(function($thread) {
            $thread->replies->each(function($reply) {
                $reply->delete();
            });
            
        });


    }

    public function path()
    {
    	return '/threads/' . $this->channel->slug .'/'. $this->id;
    }

   

    public function replies()
    {
    	return $this->hasMany('App\Reply');
                    
    }

    public function subscribe()
    {
        $this->subscriptions()->create([
                'user_id' => Auth::id()
            ]);
    }

    public function isSubscribed()
    {
        return $this->subscriptions()
                    ->where('user_id', Auth::id())
                    ->exists();
    }

    public function unsubscribe()
    {
        $this->subscriptions()
             ->where('user_id', Auth()->id())
             ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Subscribe');
    }

 

    public function owner()
    {
    	return $this->belongsTo('App\user', 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

    public function hasMarkedReply()
    {
        if($this->replies()->where('marked', 1)->exists())
        {
            return true;
        }
        return false;
    }

    public function scopeFilter($query, $filters)
    {
        $filters->apply($query);
    }
}
