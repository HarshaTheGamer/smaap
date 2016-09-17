<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Like;
use App\User;
use Auth;
use App\friends;
use DB;
// use friendRequest;


class ChatController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    //
    public function checkfriendship(Request $request) {

    	$user_email = $request->user2;
        $id= User::select('id')->where('email',$user_email)->first();
        $user2id=$id->id;
         // Auth::user()->id;
        if(friendRequest::areFriends(Auth::user()->id,$user2id)){
            return "true";
        }
        else {
            return "false";
        }
    }
    public function getprofilepic(Request $request) {

        $user2chatid=$request->user2;
        $a=User::select('profile')->where('chat_id',$user2chatid)->first();
        if (!empty($a)) {
            # code...
            return $a->profile;
        }
        return "default.jpg";
    }
    public function chatroom(Request $request) {

        return view('chatroom');
    }

    public function createprivatechat(Request $request) {

    	$user2id=$request->chatuser;
    	return view('chatbox', [
    			'chatuser' => $user2id,
    		]);

    }
    public function updateChatId(Request $request) {

        $chat_id=$request->chat_id;
        $user_email= $request->user_email;
        $a=User::where('email',$user_email)->update(array('chat_id'=>$chat_id));
        return $a;       

    }
    
}
