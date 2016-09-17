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

class usercontroller extends Controller
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

	public function myprofile() {


		return view('profile');
		
	}
	public function likers() {
		$likedBy=Like::select('user_one')->where('user_two',\Auth::user()->id)->where('anonymous_like',0)->get();
		$alikedBy=Like::select('user_one')->where('user_two',\Auth::user()->id)->where('anonymous_like',1)->get();
		if (count($likedBy)>0 && count($alikedBy)==0) {
			foreach ($likedBy as $lb) {
			$likers[] = User::where('id',$lb->user_one)->get();
			}
			return view('userlist.likers',[

				'likers' => $likers,

				]);
		}
		if (count($alikedBy)>0 && count($likedBy)==0) {
			foreach ($alikedBy as $lb) {
			$alikers[] = User::where('id',$lb->user_one)->get();
			}
			return view('userlist.likers',[

				'alikers' => $alikers,

				]);
		}
		if (count($likedBy)>0 && count($alikedBy)>0) {
			foreach ($likedBy as $lb) {
			$likers[] = User::where('id',$lb->user_one)->get();
			}
			foreach ($alikedBy as $lb) {
			$alikers[] = User::where('id',$lb->user_one)->get();
			}
			return view('userlist.likers',[

				'likers' => $likers,
				'alikers' => $alikers,

				]);
		}
		if (count($likedBy)==0 && count($alikedBy)==0) {
			$nolikes = 1;
			return view('userlist.likers',[

				'nolikes' => $nolikes,

				]);
		}
	}

    public function likeprofile(Request $request)
	    {

	    	$l = Like::where('user_one',$request->user1)->where('user_two',$request->user2)->get();
	    	if(count($l)==0){
	    		$like = new Like;
		    	$like->user_one = $request->user1;
		    	$like->user_two=$request->user2;
		    	$like->like_user= true;
		     	$like->save();
		     	if(usercontroller::likeme($request->user1,$request->user2)) {
		     			if(!friendRequest::areFriends($request->user1,$request->user2)){
		     				friends::where('user_one',$request->user1)->where('user_two',$request->user2)->delete();
		     				friends::where('user_two',$request->user1)->where('user_one',$request->user2)->delete();
		     				DB::table('friends')->insert(array('user_one' => $request->user1, 'user_two' => $request->user2, 'request_count' => 1));
		     				DB::table('friends')->where('user_one', '=', $request->user1)->where('user_two', '=', $request->user2)->update(array('status'=>1));
		     				$data=array('lc' => Like::where('user_two',$request->user2)->count(), 'likematch' => 'true' );
	    					return $data;
		     			}		
		     		}
	    	}
	    	else {
	    		Like::where('user_one',$request->user1)->where('user_two',$request->user2)->update(array('like_user'=>true));
	    	}
	    	$data=array('lc' => Like::where('user_two',$request->user2)->count(), 'likematch' => 'false' );
	    	return $data;

	    }
	 public function alikeprofile(Request $request)
	    {
	    	$l = Like::where('user_one',$request->user1)->where('user_two',$request->user2)->get();
	    	if(count($l)==0){
	    		$like = new Like;
		    	$like->user_one = $request->user1;
		    	$like->user_two=$request->user2;
		    	$like->like_user= true;
		    	$like->anonymous_like= true;
		     	$like->save();
	    	}
	    	else {
	    		Like::where('user_one',$request->user1)->where('user_two',$request->user2)->update(array('like_user'=>true, 'anonymous_like'=>true));
	    	}
	    	return Like::where('user_two',$request->user2)->count();

	    }
	public function unlikeprofile(Request $request)
	    {
	    	Like::where('user_one',$request->user1)->where('user_two',$request->user2)->delete();
	    	// $l = Like::where('user_one',$request->user1)->where('user_two',$request->user2)->get();
	    	// if(count($l)==0){
	    	// 	$like = new Like;
		    // 	$like->user_one = $request->user1;
		    // 	$like->user_two=$request->user2;
		    // 	$like->like= true;
		    //  	$like->save();
	    	// }
	    	// else {
	    	// 	Like::where('user_one',$request->user1)->where('user_two',$request->user2)->update(array('like'=>true));
	    	// }
	    	return Like::where('user_two',$request->user2)->count();

	    }
	 public function likeme($user1,$user2){
	 	$like = Like::where('user_one',$user2)->where('user_two',$user1)->get();
        if ( count($like)==1 ) {
            return true;
        }
        else {
        	return false; 
        }
        
	 }
	 
	 public function getzoneusers(Request $request){
	 	if (!empty($request->key)) {
	 		$key= $request->key;
	 		$zonename= Auth::user()->zone_name;
		 	if (!empty($zonename)) {
		 		$zoneusers= User::where('zone_name',$zonename)->where('id', '<>', Auth::user()->id)->where('name', '<>', 'admin')->where('name','like','%'.$key.'%')->get();
			 	return view('zoneusers',[
			 			'zoneusers' => $zoneusers,
			 		]);  
		 	}
		 	else {
		 		return "you are not in any zone";
		 	}
	 	} else {
	 		$zonename= Auth::user()->zone_name;
		 	if (!empty($zonename)) {
		 		$zoneusers= User::where('zone_name',$zonename)->where('id', '<>', Auth::user()->id)->where('name', '<>', 'admin')->get();
			 	return view('zoneusers',[
			 			'zoneusers' => $zoneusers,
			 		]);  
		 	}
		 	else {
		 		return "you are not in any zone";
		 	}

	 	} 	
	 	
	 	      
	 }

	 public function updatestatus(Request $request) {
	 	\App\User::where('email',Auth::user()->email)->update(['userstatus'=>$request->userstatus]);
	 	\Session::flash('flash_message','Status updated Successfully.');
        return redirect()->back();
	 }

	 public function anonymousprofile(Request $request) {
	 	$user1 = $request->user1;
        $user2 = $request->user2;
        $user2profile = DB::table('users')->where('id', $user2)->get();
        $statusfriends = DB::table('friends')
                    ->select('status','request_count','reject_count')
                    ->where(array('user_one' => $user1, 'user_two' => $user2))->get();
        $rstatusfriends = DB::table('friends')
                    ->select('status','request_count','reject_count')
                    ->where(array('user_one' => $user2, 'user_two' => $user1))->get();
            if(count($statusfriends)!=0) {
                foreach ($statusfriends as $statusfriend) {
                    $status=$statusfriend->status;
                    $request=$statusfriend->request_count;
                    $reject=$statusfriend->reject_count;
                 }
                return view('anonymousprofile', [
                    'user2profile' => $user2profile,
                    'status' => $status,
                    'request' => $request,
                    'reject' => $reject,
                ]);
            }        
            elseif(count($rstatusfriends)!=0) {
                  foreach ($rstatusfriends as $rstatusfriend) {
                    $status=$rstatusfriend->status;
                    $request=$rstatusfriend->request_count;
                    $reject=$rstatusfriend->reject_count;
                 }
                 if ($request == 1) {
                    $request = 2;
                  } 

                return view('anonymousprofile', [
                    'user2profile' => $user2profile,
                    'status' => $status,
                    'request' => $request,
                    'reject' => $reject,
                ]);
            }
            else {
                $status=0;
                $request=0;
                $reject=0;
                return view('anonymousprofile', [
                    'user2profile' => $user2profile,
                    'status' => $status,
                    'request' => $request,
                    'reject' => $reject,
                ]);

            }
	 }

}
