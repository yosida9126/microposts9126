<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Micropost;

class FavoritesController extends Controller
{
    public function store($id)
    {
         // 認証済みユーザがidのmicropostをお気に入り登録
        \Auth::user()->favorite($id);
        
        return back();
    }
    
        public function destroy($id)
    {
        //認証済みユーザがidのmicropostのお気に入り解除
        \Auth::user()->unfavorite($id);
        
        return back();
    }
    
}
