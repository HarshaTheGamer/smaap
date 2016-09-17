<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Zone;
use App\User;
use Auth;
use Image;
use File;
use DB;
use App\friends;
use App\Like;
use DateTime;


class AndroidController extends Controller
{

    public function index(Request $request)
    {

    	
    	
    }

    public function AcceptReject(Request $request) {
    	if (isset($request->email)) {
    		if (!Auth::check()) {
	            $email = $request->email;
	            $u = User::where('email', $email)->first();
	            Auth::login($u);
	        }
	       	$user1 = Auth::user()->id;

	       	// To return all friends of the auth user
	    	if ($request->status == "friends") {
	    		$friends = array();
		        $first = DB::table('friends')->select('user_one')->where('user_two','=', Auth::user()->id)->where('status','=', 1)->distinct()->get();
		        $Friends = DB::table('friends')->select('user_two')->where('user_one','=', Auth::user()->id)->where('status','=', 1)->distinct()->get();
		        if (count($Friends)!=0) {
		            foreach ($Friends as $friend) {
		                $friends[] = DB::table('users')->where('id','=',$friend->user_two)->first();
		            }
		        }
		        if(count($first)!=0) {
		            foreach ($first as $friend) {
		                $friends[] = DB::table('users')->where('id','=',$friend->user_one)->first();
		            }

		        }
		            return json_encode($friends);
	    	}
    		
    	}
    	if (!Auth::check()) {
	            $email = $request->user1;
	            $u = User::where('email', $email)->first();
	            Auth::login($u);
	        }
	       	$user1 = Auth::user()->id;    	
	        $user2 = \App\User::select('id')->where('email',$request->user2)->first();
	        $user2 = $user2->id;

// To reject accept request
        if ($request->status == "accept") {
	        DB::table('friends')->where('user_one', '=', $user2)->where('user_two', '=', $user1)->update(array('status'=>1,'request_count'=>0));
	        DB::table('friends')->where('user_one', '=', $user1)->where('user_two', '=', $user2)->update(array('status'=>1,'request_count'=>0));
	        return "accepted";
    	}

// To reject friend request
    	if ($request->status == "reject") {
	        DB::table('friends')->where('user_one', '=', $user2)->where('user_two', '=', $user1)->update(array('status'=>0,'request_count'=>0,'reject_count'=>1));
	        return "Rejected";
    	}




// To unfriend
    	if ($request->status == "unfriend") {
	        DB::table('friends')
		    	->where('user_one',$user1)
		    	->where('user_two',$user2)
		    	    ->delete();
			DB::table('friends')
    		   	->where('user_one',$user2)
		    	->where('user_two',$user1)
		    		->delete();
		    return "success";

    	}

    }

    public function like(Request $request) {

    	if (isset($request->user1)) {
    		if (!Auth::check()) {
            $email = $request->user1;
            $u = User::where('id', $email)->first();
            Auth::login($u);
	        }
	       	$user1 = Auth::user()->id;
	       	$likedBy=\App\Like::select('user_one')->where('user_two',$user1)->where('anonymous_like',0)->get();
			$alikedBy=\App\Like::select('user_one')->where('user_two',$user1)->where('anonymous_like',1)->get();


	// To return all users who liked auth user
	        if ($request->status == "likers") {

	        	$likers=array();
	        	foreach ($likedBy as $lb) {
					$likers[] = User::where('id',$lb->user_one)->first();
				}
				return $likers;

	    	}

	// To return all users who anonymously liked auth user
	    	if ($request->status == "alikers") {
	        	$alikers=array();
	        	foreach ($alikedBy as $lb) {
					$alikers[] = User::where('id',$lb->user_one)->first();
				}
				return json_encode($alikers);

	    	}
    	}


    	// $user2 = \App\User::select('id')->where('email',$request->user2)->first();
    	$user2 = $request->user2;
// To update like status
    	if ($request->status == "like") {
    		$l = \App\Like::where('user_one',$user1)->where('user_two',$user2)->get();
	    	if(count($l)==0){
	    		\App\Like::insert(array('user_one'=>$user1,'user_two'=>$user2, 'like_user'=>1));
	    		$usercontroller = new usercontroller;
		     	if($usercontroller->likeme($user1,$user2)) {
		     			if(!friendRequest::areFriends($user1,$user2)){
		     				friends::where('user_one',$user1)->where('user_two',$user2)->delete();
		     				friends::where('user_two',$user1)->where('user_one',$user2)->delete();
		     				DB::table('friends')->insert(array('user_one' => $user1, 'user_two' => $user2, 'request_count' => 1));
		     				DB::table('friends')->where('user_one', '=', $user1)->where('user_two', '=', $user2)->update(array('status'=>1));
		     				$data=array('lc' => Like::where('user_two',$user2)->count(), 'likematch' => 'true' );
	    					return $data;
		     			}		
		     		}
	    	}
	    	else {
	    		\App\Like::where('user_one',$user1)->where('user_two',$user2)->update(array('like_user'=>true));
	    	}
	    	$data=array('lc' => \App\Like::where('user_two',$user2)->count(), 'likematch' => 'false' );
	    	return $data;
    	}

// To update anonymously like status
    	if ($request->status == "alike") {
    		$l = \App\Like::where('user_one',$user1)->where('user_two',$user2)->get();
	    	if(count($l)==0){
	    		\App\Like::insert(array('user_one'=>$user1,'user_two'=>$user2, 'anonymous_like'=>1));
	    		$usercontroller = new usercontroller;
		     	if($usercontroller->likeme($user1,$user2)) {
		     			if(!friendRequest::areFriends($user1,$user2)){
		     				friends::where('user_one',$user1)->where('user_two',$user2)->delete();
		     				friends::where('user_two',$user1)->where('user_one',$user2)->delete();
		     				DB::table('friends')->insert(array('user_one' => $user1, 'user_two' => $user2, 'request_count' => 1));
		     				DB::table('friends')->where('user_one', '=', $user1)->where('user_two', '=', $user2)->update(array('status'=>1));
		     				$data=array('lc' => Like::where('user_two',$user2)->count(), 'likematch' => 'true' );
	    					return $data;
		     			}		
		     		}
	    	}
	    	else {
	    		\App\Like::where('user_one',$user1)->where('user_two',$user2)->update(array('like_user'=>true));
	    	}
	    	$data=array('lc' => \App\Like::where('user_two',$user2)->count(), 'likematch' => 'false' );
	    	return $data;
    	}
    	
    }

    public function zoneusers(Request $request) {
    	if (!Auth::check()) {
            $email = $request->email;
            $u = User::where('email', $email)->first();
            Auth::login($u);
        }
       	// return $user1 = Auth::user()->id;
       	// return $request->zonename;
       	return \App\User::where('zone_name',$request->zonename)->get();

    }

    public function updateChatId(Request $request) {

    	$chat_id = $request->chat_id;
        $user_email= $request->user_email;
        $a=User::where('email',$user_email)->update(array('chat_id'=>$chat_id));
        return $a;       

    }


    public function sendfr(Request $request) {

        $user2email= $request->user2;
         if (!Auth::check()) {
            $email = $request->user1;
            $u = User::where('email', $email)->first();
            Auth::login($u);
        }

        $user1 = Auth::user()->id;
        $user2 = User::select('id')->where('email',$user2email)->first();
        $result=DB::table('friends')->select('*')
		    	->where('user_one',$user1)
		    	->where('user_two',$user2->id)
		    	    ->get();
		$user2profile = DB::table('users')->where('id', $user2)->get();
		if(!friendRequest::areFriends($user1,$user2->id)) {
			if(count($result)==0) {
		 	$result=DB::table('friends')
		    	->where('user_one',$user2->id)
		    	->where('user_two',$user1)
		    	    ->delete();
		 	DB::table('friends')->insert(array('user_one' => $user1, 'user_two' => $user2->id, 'request_count' => 1));
		 	return "Friend request sent";
		 }
		 else {
		 	$result=DB::table('friends')->select('*')
		    	->where('user_one',$user1)
		    	->where('user_two',$user2->id)
		    	->where('request_count',1)
		    	    ->get();
		    if (count($result)==0) {
		    	DB::table('friends')->where('user_one',$user1)->where('user_two',$user2->id)->update(array('request_count' => 1));
		 		return "Friend request sent";
		    } else {
		    	return "Friend request already sent";
		    }
		 	
		 }

		} else {
			return "already friends";
		}
		 
    }

    




}