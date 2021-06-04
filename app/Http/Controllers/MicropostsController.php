<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Micropost;
use App\Common\tagCommonClass;

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
        $post = $request->user()->microposts()->create([
                'content' => $request->content,
            ]);

        //タグの作成
        //$tag = $request->tag;
        //全角半角の調整、大文字を小文字に変換
        //$tag = strtolower(mb_convert_kana($tag, "KVas"));
        //$tagをexplodeにかけて文字列を配列にわける（区切り文字はスペースで）
        //$tags = explode(' ',$tag);
        //配列に重複したものがあれば削除
        //$tags = array_unique($tags);

        //$request->tagの文字列を確認(上記コメントアウトの機能)
        $tags = tagCommonClass::tagcheck($request->tag);

        //分けたタグを検索して存在してなければ作成
        foreach($tags as $tag){
          $tag = Tag::firstOrCreate(['tag' => $tag]);
            //contentと紐づけ
            $post->tagging($tag->id);
        }
            
        //リダイレクト
        return back();
    }
    
    public function show($id)
    {
        $micropost = Micropost::findOrFail($id);
        
        $user = $micropost->user()->first();
        
        $user->loadRelationshipCounts();
        
        $tags = $micropost->tags()->get();
        
        return view('microposts.show',[
                'micropost' => $micropost,
                'user' => $user,
                'tags'=> $tags,
            ]);
    }
    
    public function edit($id)
    {
        $micropost = Micropost::findOrFail($id);
        
        $user = $micropost->user()->first();
        
        $tags = $micropost->tags()->get();
        
        foreach($tags as $tag)
        {
            $values[] = $tag->tag;
        }
        
        $tags = implode(" ",$values);

        return view('microposts.edit',[
                'micropost' => $micropost,
                'user' => $user,
                'tags'=> $tags,
            ]);
    }
    
    public function update(Request $request,$id)
    {
        $post = Micropost::findOrFail($id);
        
        //以前に紐づけされたタグを取得
        $tags = $post->tags()->get();
        
        $post->content = $request->content;
        $post->save();
        

        //前回紐づけされたタグを一旦解除
        foreach($tags as $tag)
        {
            $post->untagging($tag->id);
        }
        
        $tag = null;
        $tags = null;
        
        //$request->tagの文字列を確認(storeと同じ)
        $tags = tagCommonClass::tagcheck($request->tag);

        //分けたタグを検索して存在してなければ作成
        foreach($tags as $tag){
            $tag = Tag::firstOrCreate(['tag' => $tag]);
            //contentと紐づけ
            $post->tagging($tag->id);
        }
        
        return redirect('/');
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
