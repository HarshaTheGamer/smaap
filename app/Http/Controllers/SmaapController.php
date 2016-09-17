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
use DateTime;
use Activity;


class SmaapController extends Controller
{

    public function index()
    {

    }

    // for login
    public function login(Request $request)
    {
                // return md5($request->password);
        $email=$request->email;
        $validator = Validator::make(Input::all(),User::$login_validation_rules);
        if($validator->fails()){

          $data = array(
                        'status' => 'Failure'
                        );
                    return json_encode($data);
        }
        $u = User::where('email', $email)->first();  
        if($u != NULL) {
            $password = md5($request->password);

            if($u->password == $password){
                    Auth::login($u);
                    Activity::log('logged in');
// date of birth format
                    $source = Auth::user()->birthday;
                    $date = new DateTime($source);
                    $newdate= $date->format('M-d-Y');
// end  date of birth format

                    $likes_count = \App\Like::where('user_two',Auth::user()->id)->where('anonymous_like',0)->count();
                    $alikes_count = \App\Like::where('user_two',Auth::user()->id)->where('anonymous_like',1)->count();
                    $friendRequest_count = \App\friends::where('user_two',Auth::user()->id)->where('request_count',1)->count();

                    $data = array(
                    'username' => Auth::user()->name,
                                    'email' => Auth::user()->email,
                                    'birthday' => $newdate,
                                    'gender' => Auth::user()->gender,
                                    'phone' => Auth::user()->phone,
                                    'pic' => Auth::user()->profile,
                                    'id' => Auth::user()->id,
                                    'likes_count' => $likes_count,
                                    'alikes_count' => $alikes_count,
                                    'friendRequest_count' => $friendRequest_count,
                                    'userstatus' => Auth::user()->userstatus,
                                    'crftoken' => csrf_token()
                                    
                            );

                        header('Content-Type: application/json');

                       return  json_encode($data);
            }else {
                $data = array(
                        'status' => 'password not valid'
                        );
                    return json_encode($data);
            }  
        }

    }
    // for logout
    public function logout(Request $request)
    {
        if (!Auth::check()) {
            DB::table('users')
            ->where(['email' => $request->email ])
            ->update(['zone_name' => '' ]);
            return "session not found";
        }
         DB::table('users')
        ->where(['email' => $request->email ])
        ->update(['zone_name' => '' ]);
        Activity::log('logged out');
        Auth::logout();
        return "logout success";

    }
    public function friendrequests(Request $request)
    {
        $friendrequests= \App\friends::select('user_one')->where('user_two',Auth::user()->id)->where('request_count',1)->get();
        if (count($friendrequests)==0) {
            return "0 results";
        }
        else {
            foreach ($friendrequests as $key) {
            $jsonData[]=\App\User::where('id',$key->user_one)->first();
            }
            return json_encode($jsonData);
        }
        
    }

    public function latlng(Request $request)
    {
        
        return \App\Zone::all();

    }

    public function userstatus(Request $request)
    {
        if (!Auth::check()) {
            $email = $request->email;
            $u = User::where('email', $email)->first();
            if(Auth::login($u)){

            } else {
                return $email;
            }
        }
        
        \App\User::where('email',Auth::user()->email)->update(['userstatus'=>$request->userstatus]);
        return $request->userstatus;

    }

    public function zonelang(Request $request)
    {
        
        return \App\Zone::select('latitude','longitude','range')->where('zone_name',$request->zonename)->first();

    }

    public function newrequest(Request $request)
    {
        $max = \App\friends::where('user_two',Auth::user()->id)->where('request_count',1)->max('fid');
        $friendrequests= \App\friends::select('user_one')->where('user_two',Auth::user()->id)->where('request_count',1)->where('fid',$max)->get();
        if (count($friendrequests)==0) {
            return "0 results";
        }
        else {
            foreach ($friendrequests as $key) {
            $jsonData[]=\App\User::where('id',$key->user_one)->first();
            }
            return json_encode($jsonData);
        }
        
    }

    public function currentzone(Request $request)
    {
        if (!Auth::check()) {
            $email = $request->email;
            $u = User::where('email', $email)->first();
            Auth::login($u);
        }
        $clat=$request->lat;
        $clng=$request->lng;

        // For activity log
        if ($clat != 0.0 && $clng != 0.0) {
        
            $location = json_encode(array('lat'=> $clat, 'lng' => $clng));
            $a = DB::table('activity_log')->where('text','location')->where('user_id',Auth::user()->id)->orderBy('created_at', 'desc')->first();
            if (!empty($a)) {
                $oldlocation = json_decode($a->location);
                 $newdistance = $this->getDistance( $oldlocation->lat, $oldlocation->lng, $clat, $clng );
                 if($newdistance > 0.1609) {
                    Activity::log('location');
                    $a = DB::table('activity_log')->where('text','location')->where('user_id',Auth::user()->id)->orderBy('created_at', 'desc')->first();
                    DB::table('activity_log')->where('id',$a->id)->update(array('location'=> $location));
                 }
            }else {
                Activity::log('location');
                $a = DB::table('activity_log')->where('text','location')->where('user_id',Auth::user()->id)->orderBy('created_at', 'desc')->first();
                DB::table('activity_log')->where('id',$a->id)->update(array('location'=> $location));
            }    

        }
        
        //End log

        $i = 0;
        $zones=\App\Zone::all();
        $curzone = Auth::user()->zone_name;
        foreach ($zones as $zone) {
            $jsonData[] = $zone;
            $lat1 = $zone['latitude'];
            $lng1 = $zone['longitude'];
            $zonename = $zone['zone_name'];
            $rad = ($zone['range']*1609.344)/1000;
            $distance = $this->getDistance( $lat1, $lng1, $clat, $clng );
            if( $distance < $rad ) {
                \App\User::where('email',Auth::user()->email)->update(['zone_name' => $zonename]);
                $czone[]=$zonename;
                $radi[]=$rad;
                $i++;

            }
        }

        if($i==0){
            if ($curzone !='') {
                    \App\User::where('email',Auth::user()->email)->update(['recent_zone' => Auth::user()->zone_name]);
                    \App\User::where('email',Auth::user()->email)->update(['zone_name' => '']);
                }
            return "you are not in any zone";
        }
        elseif($i==2){

            if($radi[0]<$radi[1]){
            
                if ($curzone !=$czone[0]) {
                    \App\User::where('email',Auth::user()->email)->update(['recent_zone' => Auth::user()->zone_name]);
                    \App\User::where('email',Auth::user()->email)->update(['zone_name' => $czone[0]]);
                }

            $data= array(
                    'zone' => $czone[0]
                    );
             return json_encode($data);
            }
            else {
             if ($curzone !=$czone[1]) {
                    \App\User::where('email',Auth::user()->email)->update(['recent_zone' => Auth::user()->zone_name]);
                    \App\User::where('email',Auth::user()->email)->update(['zone_name' => $czone[1]]);
                }
             $data= array(
                    'zone' => $czone[1]
                    );
             return json_encode($data);
            }
            
        }
        else {
            if ($curzone !=$czone[0]) {
                    \App\User::where('email',Auth::user()->email)->update(['recent_zone' => Auth::user()->zone_name]);
                    \App\User::where('email',Auth::user()->email)->update(['zone_name' => $czone[0]]);
                }
             $data= array(
                    'zone' => $czone[0]
                    );
             return json_encode($data);
        }      

    }

    public function getDistance( $latitude1, $longitude1, $latitude2, $longitude2 ) {  
        $earth_radius = 6371;

        $dLat = deg2rad( $latitude2 - $latitude1 );  
        $dLon = deg2rad( $longitude2 - $longitude1 );  

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
        $c = 2 * asin(sqrt($a));  
        $d = $earth_radius * $c;  

        return $d;  
    }

    public function uploadFile(Request $request)
    {

                // Handle the user uploads of images
        if($request->hasFile('file')){

            $avatar = $request->file('file'); 
            $user =\App\User::where('email',$request->description)->first();
            $filename = $request->description.'.'.$avatar->getClientOriginalExtension();
            $path = 'images/' . $filename;
            if($user->profile != "default.jpg") {

                File::delete($path);

            }
            Image::make($avatar)->resize(450,450)->save($path);
            \App\User::where('email',$request->description)->update(['profile' => '/laravel/public/images/'.$filename]);
            return "Success";
  
        } else {
            return "fail";
        }
    }

    public function gallery(Request $request)
    {

       $data = array('/laravel/public/images/h@h.h.png','/laravel/public/images/harsha.m.n1993@gmail.com.jpg', '/laravel/public/images/ imran@gmail.com.jpg','/laravel/public/images/ram@gmail.com.png'               
                                    
                            );

                        header('Content-Type: application/json');

                       return  json_encode($data);        
    }

    public function register(Request $request)
    {
        $validator = Validator::make(Input::all(),User::$register_validation_rules);
        if($validator->fails()){
          return $validator->errors();
        }
        else {
           User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => md5($request['password']),
            'birthday' => $request['birthday'],
            'gender' => $request['gender'],
            'phone' => $request['phone']
            ]);
           $u=User::where('email',$request['email'])->first();
           Auth::login($u);
           User::where('email',$request['email'])->update(array('created_at'=>Auth::user()->updated_at));       
           Activity::log("Registered Successfully");
           return "Successfully Registered";
        }
       
    }
  

}
