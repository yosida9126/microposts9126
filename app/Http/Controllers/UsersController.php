<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
    public function index()
    {
        //ユーザ一覧をidの降順で取得
        $users = User::orderBy('id','desc')->paginate(10);
        
        //ユーザ一覧ビューでそれらを表示
        return view('users.index',[
                'users' => $users,
            ]);
    }
    
    public function show($id)
    {
        //idの値でユーザを検索、取得
        $user = User::findOrFail($id);
        
        //関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        //ユーザの投稿一覧を作成日時の降順で取得
        $microposts = $user->microposts()->orderBy('created_at','desc')->paginate(10);
        
        //ユーザ詳細ビューでそれらを表示
        return view('users.show',[
                'user' => $user,
                'microposts' => $microposts,
            ]);
    }
    
    public function followings($id)
    {
        //idの値でユーザを検索、取得
        $user = User::findOrFail($id);
        
        //関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        //ユーザのフォロー一覧取得
        $followings = $user->followings()->paginate(10);
        
        //フォロー一覧ビューに表示
        return view('users.followings',[
                'user' => $user,
                'users' => $followings,
            ]);
    }
    
    public function followers($id)
    {
        //idの値でユーザを検索、取得
        $user = User::findOrFail($id);
        
        //関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        //ユーザのフォロワー一覧取得
        $followers = $user->followers()->paginate(10);
        
        return view('users.followers',[
                'user' => $user,
                'users' => $followers,
            ]);
    }
    
        public function favorites($id)
    {
        //idの値でタイムラインを検索、取得
        $micropost = User::findOrFail($id);
        
        //関係するモデルの件数をロード
        $micropost->loadRelationshipCounts();
        
        //ユーザのお気に入り一覧取得
        $favorites = $micropost->favorites()->paginate(10);
        
        //お気に入り一覧ビューに表示
        return view('users.favorites',[
                'user' => $micropost,
                'microposts' => $favorites,
            ]);
    }
}
