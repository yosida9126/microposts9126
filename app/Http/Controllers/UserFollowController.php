<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    public function store($id)
    {
        //認証済みユーザがidのユーザをフォロー
        \Auth::user()->follow($id);
        
        return back();
    }
    
    public function destroy($id)
    {
        //認証済みユーザがidのユーザをアンフォロー
        \Auth::user()->unfollow($id);
        
        return back();
    }
}
