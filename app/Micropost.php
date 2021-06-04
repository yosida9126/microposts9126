<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = [
            'content',
        ];
        
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function favorite_users()
    {
        return $this->belongsToMany(User::class,'favorites','micropost_id','user_id')->withTimestamps();
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class,'post_tag','post_id','tag_id')->withTimestamps();
    }
    
    public function tagging($postId)
    {
        $this->tags()->attach($postId);
        return true;
    }
    
    public function untagging($postId)
    {
        $this->tags()->detach($postId);
        return true;
    }
}
