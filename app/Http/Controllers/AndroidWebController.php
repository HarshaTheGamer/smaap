<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;
use DB;
use File;
use Image;
use App\friends;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class AndroidWebController extends Controller {

	public function updateFriendRequest($user1, $user2) {
		$result=DB::table('friends')->select('*')
		    	->where('user_one',$user1)
		    	->where('user_two',$user2)
		    	    ->first();
		$newrc=$result->reject_count+1;
		return friends::where('user_one',$user1)->where('user_two',$user2)->update(array('request_count'=>1,'reject_count'=>$newrc));


	}

	public function uploadToGallery(Request $request){
		if (!Auth::check()) {
            $email = $request->email;
            $u = User::where('email', $email)->first();
            Auth::login($u);
        }
	   		$input = Input::all();
	        $rules = array(
	            'file' => 'image|max:3000',
	        );

	        $validation = Validator::make($input, $rules);

	        if ($validation->fails())
	        {
	            return \Response::json("Uploaded file is not image", 400);
	        }
	        if(!File::exists('uploads/'.Auth::user()->email)) {
	            $result = File::makeDirectory('uploads/'.Auth::user()->email, 0777, true, true);
	        }
	        
	        $file = Input::file('file');
	        $filename =sha1(time().time()).'.'.$file->getClientOriginalExtension();
	        $path = 'uploads/'.Auth::user()->email.'/'.$filename;
	        $upload_success = Image::make($file)->resize(450,450)->save(public_path($path)); 

	        if( $upload_success ) {
	            return \Response::json('success', 200);
	        } else {
	            return \Response::json('error', 400);
	        }
	}

	public function galleryImages(Request $request) {
		$files = File::allFiles('uploads/'.$request->email);
		foreach ($files as $file)
		{
		    $data[]="http://54.215.249.200/laravel/public/".(string)$file;
		}
		return $data;
	}
}