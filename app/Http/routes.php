<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Http\Response;

// get('protected', ['middleware' => ['auth', 'admin'], function() {
//     return "this page requires that you be logged in and an Admin";
// }]);


Route::get('apks/download', function(Request $request) {
    return "true";
});

Route::post('checkemail', function(Request $request) {
    $validator = Validator::make(array('email'=>$request->email),User::$email_validation_rules);
    if($validator->fails()){
        $validator = Validator::make(array('email'=>$request->email),User::$email_rules);
        if($validator->fails()){
            return "wrong";
        }else {
            return "pass";
        }
    }
    else {
        return "fail";
    }
});

Route::post('checkname', function(Request $request) {

        $validator = Validator::make(array('name'=>$request->name),User::$name_rules);
        if($validator->fails()){
            return "wrong";
        }else {
            return "pass";
        }
});

Route::get('', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('download', function (Request $request) {
  echo "<p style='color: red; font-weight: bold;'>Since the application has not been downloaded from app store you may find this version of app is harmfull to your device while installing, so please ignore and install the app</p>";
  echo "<a href='apks/smaap1.5.apk' download='smaap' target='_blank' class='btn btn-primary inverse scrollpoint sp-effect1'>
                                <i class='fa fa-android fa-3x pull-left'></i>
                                <span>Click Here to download smaap1.5.apk for</span><br>
                                <b>Android</b>
                            </a>";
});

Route::post('posttester', function(Request $request)
    {
    return "true";
});
Route::get('home', 'HomeController@index');

Route::post('handleLogin', function(Request $request)
    {
        // return md5($request->password);
        $email=$request->email;
        $validator = Validator::make(Input::all(),User::$email_validation_rules);
        if($validator->fails()){

          return back()->withInput()->withErrors($validator);
        }
        $u = User::where('email', $email)->first();  
        if($u != NULL) {
            $password = md5($request->password);
            if($u->confirmed == 0) {
                if($u->password == $password){
                    Auth::login($u);
                    DB::table('users')->where('id',Auth::user()->id)->update(array('online'=>1));
                    return redirect()->intended('smaapchat');
                }
                else {
                    $validator->getMessageBag()->add('password', 'Wrong Password');
                    return back()->withInput()->withErrors($validator);
                    
                }                    
            } else {                
                \Session::flash('alert','Email not verified. <a href="test">click here to verify your email</a>');
                return redirect('login')->withInput();
            }  
        }
        
         return back()->withInput()->withErrors('Username or Password is invalid');
    });

Route::get('logout1', function()
    {
        return view('auth.logout');
       
    });

Route::get('logoutt' , function() {
    if (!Auth::check()) {
           return Redirect::to('login');
        }
        DB::table('users')
        ->where(['id' => Auth::user()->id ])
        ->update(['zone_name' => '' ]);
        DB::table('users')->where('id',Auth::user()->id)->update(array('online'=>0));        
        Cache::flush();
        Auth::logout();
        Session::flush();
        return Redirect::to('home');

});


Route::auth();

Route::get('/smaapchat', 'HomeController@index');

Route::get('/profile', [
    'uses' => 'usercontroller@myprofile',
    'as' => 'like'
    
]);

Route::post('/uploadimage', 'HomeController@uploadimage');
Route::get('/uploadimage', [
    'uses' => 'usercontroller@myprofile',
    'as' => 'like'
    
]);


Route::post('currentLatLng', 'ZoneController@getzonename');
Route::get('currentLatLng', 'HomeController@index');

Route::post('getzoneusers', 'usercontroller@getzoneusers');
Route::get('getzoneusers', 'HomeController@index');
/**
 * Add New Zone
 */
Route::get('/zone', 'ZoneController@index');
Route::post('/zone/create', 'ZoneController@createzone');
Route::get('/zone/create', 'ZoneController@createzone');
Route::get('/editzone', 'ZoneController@editzone');
Route::post('/zone/update', 'ZoneController@updatezone');
Route::get('/zone/update', 'ZoneController@createzone');

Route::get('/zones', function () {
    if (Auth::check()) {
        $zones = Zone::orderBy('created_at', 'asc')->get();
        return view('zones', [
            'zones' => $zones
        ]);
    } else {
        return redirect('login');
    }    	

});

/**
 * Delete Zpne
 */
Route::post('/zones/delete', 'ZoneController@deletezone');

Route::post('zones/Update', 'ZoneController@updatezone');
Route::get('ViewUserProfile', 'HomeController@ViewUserProfile');

// Route::get('ViewUserProfile', 'HomeController@ViewUserProfile');

Route::post('unfriend', 'friendRequest@unfriend');
Route::get('unfriend', 'HomeController@index');
Route::post('sendfrequest', 'friendRequest@sendfrequest');
Route::get('sendfrequest', 'HomeController@index');
Route::post('cancelfriendrequest', 'friendRequest@cancel');
Route::get('cancelfriendrequest', 'HomeController@index');
Route::post('frequestNotification', 'friendRequest@frnotify');
Route::post('acceptfr', 'friendRequest@acceptfr');
Route::post('rejectfr', 'friendRequest@rejectfr');

Route::get('test', function() {
    return view('test');

});

Route::get('screenshots', function() {
    return view('screenshots.screenshots');

});

Route::post('handleregister','AuthController@handleRegister');

Route::post('verifyemail', function(Request $request) {
    $email=$request->email;
        $validator = Validator::make(Input::all(),User::$email_validation_rules);
        if($validator->fails()){

          return back()->withInput()->withErrors($validator);
    }
    $code = mt_rand(100000,999999);
    Mail::send('auth.emails.verify', ['email' => $request->email, 'code' => $code], function ($m) use ($request) {
            $m->from('harsha.m.n1993@gmail.com', 'smaap');

            $m->to($request->email, NULL)->subject('Verify email!');
        });
    User::where('email',$request->email)->update(array('confirmation_code'=>$code));
    \Session::flash('flash_message','Successfully registered!!!!, Please check your email to verify in order to login.');
    return redirect('login'); 

});

Route::get('smaap/verify', function(Request $request) {
    $code=$request->code;
    $verified= User::where('email',$request->email)->where('confirmation_code',$code)->update(array('confirmed' => 1));
    if ($verified) {
        \Session::flash('flash_message','Email successfully verified.');
        return redirect('login');   
    }
    else {
        \Session::flash('alert','Email not verified. <a href="test">click here to verify your email</a>');
        return redirect('login');

    }
});

Route::get('friends',[
    'uses' => 'HomeController@friends',
    'as' => 'friends'
    
]);
Route::get('likers',[
    'uses' => 'usercontroller@likers',
    'as' => 'likers'
    
]);
Route::get('friendrequest',[
    'uses' => 'friendRequest@frequest',
    'as' => 'friendrequest'
    
]);

Route::post('like', [
    'uses' => 'usercontroller@likeprofile',
    'as' => 'like'
    
]);
Route::post('unlike', [
    'uses' => 'usercontroller@unlikeprofile',
    'as' => 'unlike'
    
]);

Route::post('alike', [
    'uses' => 'usercontroller@alikeprofile',
    'as' => 'alike'
    
]);

Route::get('anonymousprofile', [
    'uses' => 'usercontroller@anonymousprofile',
    'as' => 'anonymousprofile'
    
]);

Route::post('checkfriendship', [
    'uses' => 'ChatController@checkfriendship',
    'as' => 'checkfriendship'
    
]);

Route::post('getprofilepic', [
    'uses' => 'ChatController@getprofilepic',
    'as' => 'getprofilepic'
    
]);

Route::get('chatbox', [
    'uses' => 'ChatController@createprivatechat',
    'as' => 'createprivatechat'
    
]);

Route::post('testpost', [
    'uses' => 'ZoneController@getzonename',
    'as' => 'getprofilepic'
    
]);

Route::post('updateChatId', [
    'uses' => 'ChatController@updateChatId',
    'as' => 'updateChatId'
    
]);

Route::get('chatroom', [
    'uses' => 'ChatController@chatroom',
    'as' => 'chatroom'
    
]);


Route::post('updatestatus', [
    'uses' => 'usercontroller@updatestatus',
    'as' => 'updatestatus'
    
]);

Route::get('zonelist', [
    'uses' => 'ZoneController@zonelist',
    'as' => 'zonelist'
    
]);
       


// ---------------------- For Android ------------------------------------- //
Route::post('smaap/like','AndroidController@like');
Route::post('smaap/AcceptReject','AndroidController@AcceptReject');
Route::post('smaap/reg','AndroidController@zoneusers');
Route::post('smaap/updateChatId', 'AndroidController@updateChatId');
Route::post('smaap/sendfr','AndroidController@sendfr');
Route::get('smaap/token',function(){
return csrf_token();
});

Route::post('smaap/login', 'SmaapController@login');
Route::get('smaap/logout','SmaapController@logout');
Route::get('smaap/friendrequests','SmaapController@friendrequests');
Route::get('smaap/latlng','SmaapController@latlng');
Route::get('smaap/newrequest','SmaapController@newrequest');
Route::post('smaap/register','SmaapController@register');
Route::post('smaap/currentzone','SmaapController@currentzone');
Route::post('smaap/uploadFile','SmaapController@uploadFile');
Route::get('smaap/userstatus','SmaapController@userstatus');
Route::post('smaap/zonelang','SmaapController@zonelang');
Route::get('smaap/upload','SmaapController@upload');
Route::post('smaap/gallery','SmaapController@gallery');

Route::post('smaap/uploadtogallery', 'AndroidWebController@uploadToGallery');


Route::get('smaap/galleryImages', 'AndroidWebController@galleryImages');

Route::post('smaap/online', function(Request $request) {
    if ($request->status=="online") {
       return DB::table('users')->where('id',$request->user1)->update(array('online'=>1));
    } else {
       return DB::table('users')->where('id',$request->user1)->update(array('online'=>0));
    }
});
