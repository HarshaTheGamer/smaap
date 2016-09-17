<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Image;
use Auth;
use File;
use DB;
use App\User;
use Redirect;
use Session;

class HomeController extends Controller
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
    public function index()
    {
        if (Auth::check()) {
            $users = User::orderBy('created_at', 'DESC')->get();
        
            return view('home', [
                'users' => $users,
            ]);
        }
        
            return redirect('login');
   
        
        
    }

    public function uploadimage(Request $request)
    {
                // Handle the user uploads of images
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar'); 
            $user =Auth::user();
            $filename = $user->email.'.'.$avatar->getClientOriginalExtension();
            $path = 'images/' . $filename;          
            if($user->profile != "default.jpg") {

                File::delete($path);

            }
            Image::make($avatar)->resize(450,450)->save($path); 
            $user->profile = '/laravel/public/images/'.$filename;
            $user->save();
            $SmaapController = new SmaapController;
            if($SmaapController->avatarUrlQB($user->email,"http://54.215.249.200/laravel/public/images/".$filename)==200) {
               return redirect('/profile');
            }
        }

        return redirect()->back();
        
        
    }

    public function ViewUserProfile(Request $request)
    {

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
                return view('userprofile', [
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

                return view('userprofile', [
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
                return view('userprofile', [
                    'user2profile' => $user2profile,
                    'status' => $status,
                    'request' => $request,
                    'reject' => $reject,
                ]);

            }

    }

     public function friends(Request $request) {
        if (!empty($request->key)) {
            $key= $request->key;

            $first = DB::table('friends')->select('user_one')->where('user_two','=', Auth::user()->id)->where('status','=', 1)->distinct()->get();

            $Friends = DB::table('friends')->select('user_two')->where('user_one','=', Auth::user()->id)->where('status','=', 1)->distinct()->get();
            

            if (count($Friends)!=0) {
                foreach ($Friends as $friend) {
                    $friends[] = DB::table('users')->where('id','=',$friend->user_two)->where('name','like', '%'.$key.'%')->get();
                }
            }
            if(count($first)!=0) {
                foreach ($first as $friend) {
                    $friends[] = DB::table('users')->where('id','=',$friend->user_one)->where('name','like', '%'.$key.'%')->get();
                }

            }

           
            if (isset($friends)) {
                return view('userlist.friends', [
                'friends' => $friends,
                ]);
            }
            else {
                return view('userlist.friends', [
                
                ]);
            }
        } else {
            $first = DB::table('friends')->select('user_one')->where('user_two','=', Auth::user()->id)->where('status','=', 1)->distinct()->get();
            $Friends = DB::table('friends')->select('user_two')->where('user_one','=', Auth::user()->id)->where('status','=', 1)->distinct()->get();
            if (count($Friends)!=0) {
                foreach ($Friends as $friend) {
                    $friends[] = DB::table('users')->where('id','=',$friend->user_two)->get();
                }
            }
            if(count($first)!=0) {
                foreach ($first as $friend) {
                    $friends[] = DB::table('users')->where('id','=',$friend->user_one)->get();
                }

            }
           
            if (isset($friends)) {
                return view('userlist.friends', [
                'friends' => $friends,
                ]);
            }
            else {
                return view('userlist.friends', [
                
                ]);
            }

        }
               
 
    }
       
}
