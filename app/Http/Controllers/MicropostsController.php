<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        
        if(\Auth::check())
        {
            $user = \Auth::user();
            
            $microposts = $user->feed_microposts()->orderBy('created_at','desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }
        //welcomeビューで表示
        return view('welcome',$data);
    }
    
    public function store(Request $request)
    {
        $request->validate([
                'content' => 'required|max:255',
            ]);
            
        //リクエストされた値を認証済みユーザの投稿として作成
        $request->user()->microposts()->create([
                'content' => $request->content,
            ]);
            
        //リダイレクト
        return back();
    }
    
    public function destroy($id)
    {
        //idの値で投稿を検索、取得
        $micropost = \App\Micropost::findOrFail($id);
        
        //認証済みユーザと同一の場合投稿を削除
        if(\Auth::id() === $micropost->user_id)
        {
            $micropost->delete();
        }
        
        //リダイレクト
        return back();
    }
}
