<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);    
    }
    
    public function loadRelationshipCounts()
    {
        $this->loadCount(['microposts','followings','followers','favorites']);
    }
    
    public function followings()
    {
        return $this->belongsToMany(User::class,'user_follow','user_id','follow_id')->withTimestamps();
    }
    
    public function followers()
    {
        return $this->belongsToMany(User::class,'user_follow','follow_id','user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        //フォロー済みか確認
        $exist = $this->is_following($userId);
        
        //自分自身でないか確認
        $its_me = $this->id == $userId;
        
        if($exist || $its_me){
            return false;
        }else{
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        //フォロー済みか確認
        $exist = $this->is_following($userId);
        
        //自分自身でないか確認
        $its_me = $this->id == $userId;
        
        if($exist && !$its_me){
            $this->followings()->detach($userId);
            return true;
        }else{
            return false;
        }
    }
    
    public function is_following($userId)
    {
        //フォロー中ユーザ内に$userIdは存在するか
        return $this->followings()->where('follow_id',$userId)->exists();
    }
    
    public function feed_microposts()
    {
        //このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        
        //このユーザのidを$userIdsの配列に追加
        $userIds[] = $this->id;
        
        //それらのユーザが所有する投稿に絞り込む
        return Micropost::whereIn('user_id',$userIds);
    }
    
    public function favorites()
    {
        return $this->belongsToMany(Micropost::class,'favorites','user_id','micropost_id')->withTimestamps();
    }
    
    public function favorite($micropostId)
    {
        //お気に入り登録済みか確認
        $exist = $this->is_favorite($micropostId);
        
        //自分自身でないか確認
        $its_me = $this->id == $micropostId;
        
        if($exist || $its_me){
            return false;
        }else{
            $this->favorites()->attach($micropostId);
            return true;
        }
    }
    
    public function unfavorite($micropostId)
    {
        //お気に入り登録済みか確認
        $exist = $this->is_favorite($micropostId);
        
        //自分自身でないか確認
        $its_me = $this->id == $micropostId;
        
        if($exist && !$its_me){
            $this->favorites()->detach($micropostId);
            return true;
        }else{
            return false;
        }
    }
    
    public function is_favorite($micropostId)
    {
        return $this->favorites()->where('micropost_id',$micropostId)->exists();
    }
}
