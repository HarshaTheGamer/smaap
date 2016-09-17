<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;
use DB;
use App\friends;

class friendRequest extends Controller
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

    public static function areFriends($user1,$user2) {    

        $friend = friends::where('user_one',$user1)->where('user_two',$user2)->where('status','1')->get();
        if ( count($friend)==1 ) {
            return true;
        }
        else {

            $friend = friends::where('user_one',$user2)->where('user_two',$user1)->where('status','1')->get();
             if ( count($friend)==1 ) {
                return true;
            }

        }
        return false; 
    }

    public function frequest(){
        $FriendRequests = DB::table('friends')->select('user_one')->where('user_two','=', Auth::user()->id)->where('status','=', 0)->where('request_count','=', 1)->get();
        if (count($FriendRequests)!=0) {
            foreach ($FriendRequests as $fruser) {
                $frequests[] = DB::table('users')->where('id','=',$fruser->user_one)->get();

            }
            $hasfriendrequest = 1;
            return view('userlist.friendrequests', [
            'frequests' => $frequests,
             'hasfriendrequest' => $hasfriendrequest,
            ]);
        }
        else {
            $hasfriendrequest = 0;
            return view('userlist.friendrequests', [
             'hasfriendrequest' => $hasfriendrequest,
            ]);
        }

    }

	public function sendfrequest(Request $request){

		$user1=$request->user1;
    	$user2=$request->user2;
    	$result=DB::table('friends')->select('*')
		    	->where('user_one',$user1)
		    	->where('user_two',$user2)
		    	    ->get();
		$user2profile = DB::table('users')->where('id', $user2)->get();
		 if(count($result)==0) {
		 	DB::table('friends')->insert(array('user_one' => $user1, 'user_two' => $user2, 'request_count' => 1));


		 	$requeststatus = DB::table('friends')
		 		->select('status','request_count','reject_count')
		 		->where(array('user_one' => $user1, 'user_two' => $user2))
		 		->get();

                foreach ($requeststatus as $rqstatus) {
                    $status=$rqstatus->status;
                    $request=$rqstatus->request_count;
                    $reject=$rqstatus->reject_count;
                 }
                return view('userprofile', [
                    'user2profile' => $user2profile,
                    'status' => $status,
                    'request' => $request,
                    'reject' => $reject,

                ]);
		 }
        $result=DB::table('friends')->select('*')
                ->where('user_one',$user1)
                ->where('user_two',$user2)
                    ->first();
        $AndroidWebController = new AndroidWebController;
		if($AndroidWebController->updateFriendRequest($user1, $user2)) {
            $requeststatus = DB::table('friends')
                ->select('status','request_count','reject_count')
                ->where(array('user_one' => $user1, 'user_two' => $user2))
                ->get();

                foreach ($requeststatus as $rqstatus) {
                    $status=$rqstatus->status;
                    $request=$rqstatus->request_count;
                    $reject=$rqstatus->reject_count;
                 }
                return view('userprofile', [
                    'user2profile' => $user2profile,
                    'status' => $status,
                    'request' => $request,
                    'reject' => $reject,

                ]);
        }

	}
    public function unfriend(Request $request){
    	$user1=$request->user1;
    	$user2=$request->user2;
    	DB::table('friends')
		    	->where('user_one',$user1)
		    	->where('user_two',$user2)
		    	    ->delete();
		DB::table('friends')
    		   	->where('user_one',$user2)
		    	->where('user_two',$user1)
		    		->delete();

		$user2profile = DB::table('users')->where('id', $user2)->get();

        $status = 0;
        $request = 0;
        $reject = 0;
		return redirect()->back();

    }
    public function can()
    {
        return "true";
    }

    public function cancel(Request $request)
    {
        $user1 = $request->user1;
        $user2 = $request->user2;
        $user2profile = DB::table('users')->where('id', $user2)->get();

        DB::table('friends')->where('user_one', '=', $user1)->where('user_two', '=', $user2)->delete();
        redirect()->back();

        

            $status=0;
            $request=0;
            $reject=0;
            return view('userprofile', [
                    'user2profile' => $user2profile,
                    'status' => $status,
                    'request' => $request,
                    'reject' => $reject,
            ]);

    }
    public function acceptfr(Request $request)
    {

        $user1 = $request->user1;
        $user2 = $request->user2;
        $user2profile = DB::table('users')->where('id', $user2)->get();
        // return redirect('ViewUserProfile?user1='.$user1.'&user2='.$user2);
        // return redirect()->action('HomeController@ViewUserProfile');

        DB::table('friends')->where('user_one', '=', $user2)->where('user_two', '=', $user1)->update(array('status'=>1));
        $requeststatus = DB::table('friends')->select('status','request_count','reject_count')->where('user_one', '=', $user2)->where('user_two', '=', $user1)->get();
        foreach ($requeststatus as $rqstatus) {
                    $status=$rqstatus->status;
                    $request=$rqstatus->request_count;
                    $reject=$rqstatus->reject_count;
                 }

        return redirect('home');

        return view('userprofile', [
                    'user2profile' => $user2profile,
                    'status' => $status,
                    'request' => $request,
                    'reject' => $reject,
            ]);


    }
    public function rejectfr(Request $request)
    {
        
        $user1 = $request->user1;
        $user2 = $request->user2;
        $user2profile = DB::table('users')->where('id', $user2)->get();
        $requeststatus = DB::table('friends')->select('status','request_count','reject_count')->where('user_one', '=', $user2)->where('user_two', '=', $user1)->get();
        if(count($requeststatus)!=0) {
            foreach ($requeststatus as $rqstatus) {
                    $status=$rqstatus->status;
                    $request=$rqstatus->request_count;
                    $reject=$rqstatus->reject_count+1;
                 }
            DB::table('friends')->where('user_one', '=', $user2)->where('user_two', '=', $user1)->update(array('request_count'=>0,'reject_count'=>$reject,));
            
            return redirect('home');
        }
        else {
            DB::table('friends')->where('user_one', '=', $user2)->where('user_two', '=', $user1)->update(array('request_count'=>0,'reject_count'=>1,));
            
            return redirect('home');  
        }
        
     }
    public function frnotify(Request $request)
    {
        $user1 = $request->user1;
        $user2 = $request->user2;
        $user2profile = DB::table('users')->where('id', $user2)->get();

        DB::table('friends')->select('user_one')->where('user_one', '=', $user2)->where('user_two', '=', $user1)->delete();
        redirect()->back();

        
    }

}
