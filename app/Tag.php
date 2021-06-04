<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
            'tag',
        ];
    
    public function posts()
    {
        return $this->belongsToMany(Micropost::class,'post_tag','tag_id','post_id')->withTimestamps();
    }
    
    public function postcounts()
    {
        $this->loadCount(['posts']);
    }
}
