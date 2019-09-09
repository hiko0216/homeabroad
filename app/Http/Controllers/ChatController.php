<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use App\User;
use App\Chat;


class ChatController extends Controller
{
    
    //個別のチャットルームへ飛ぶ
    // public function show($id)
    // {
    //     $friend = User::find($id);
    //     $posts = User::find($id)->posts;
    //     return view('chat.show')->withFriend($friend)->with('posts',$posts);
    // }
    public function see($id)
    {
        $friend = User::find($id);
        $posts = User::find($id)->posts;
        return view('chat.see')->withFriend($friend)->with('posts',$posts);
    }
    //friend　tableに追加して個別チャットルームへ
    public function getChat($id){
        $chats = Chat::where(function($query) use ($id){
            $query->where('user_id','=',Auth::user()->id)->where('friend_id','=',$id);
        })->orWhere(function($query)use($id){
            $query->where('user_id','=',$id)->where('friend_id','=',Auth::user()->id);
        })->get();

        return $chats;
    }
    public function sendChat(Request $request){
        Chat::create([
            'user_id'=>$request->user_id,
            'friend_id'=>$request->friend_id,
            'chat'=>$request->chat
        ]);

        return [];
    }
}
