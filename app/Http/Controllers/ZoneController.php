<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Zone;
use App\User;
use Auth;
use DB;

use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
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
        if (Auth::user()->email != "admin@smaap.com") {
            return redirect('/home');
        }
        $zones = Zone::orderBy('created_at', 'asc')->get();
        return view('createzone',[
                'zones' => $zones
            ]);
    }
    public function editzone(Request $request)
    {
       $zoneid=$request->id;
       $editzone = Zone::where('id',$zoneid)->first();
       $zones = Zone::orderBy('created_at', 'asc')->get();
           return view('editzone',[
                'zones' => $zones,
                'editzone' => $editzone
            ]);
    }
    public function updatezone(Request $request)
    {
        Zone::where('id',$request->id)
            ->update(array(
                'zone_name'=>$request->zonename,
                'latitude' =>$request->lat,
                'longitude' => $request->lng,
                'range' => $request->range,
                ));
        \Session::flash('flash_message',$request->zonename.' Zone updated successfully.');
        $zones = Zone::orderBy('created_at', 'asc')->get();
        return redirect('/zones');
    }

    public function getzonename(Request $request){
        $Latitude = $request->lat;
        $Longitude= $request->lng;
        $curzone = Auth::user()->zone_name;
        $zones = Zone::orderBy('created_at', 'asc')->get();
        $count = 0;
        foreach ($zones as $zone) {
             $lat1 = $zone->latitude;
            $lng1 = $zone->longitude;
            $zonename = $zone->zone_name;
            $rad= $zone->range * 1.5;
            $rad = ($rad*1609.344)/1000;
            $distance = ZoneController::getDistance( $lat1, $lng1, $Latitude, $Longitude );
            if( $distance < $rad ) {
                $zonename_list[]=$zonename;
                $rad_list[]=$rad;
                $count++;
            } else {
                
            }

        }
         if ($count == 2) {
            if ($rad_list[0]<$rad_list[1]) {
                $user = User::find(Auth::user()->id);
                $user->zone_name = $zonename_list[0];
                $user->recent_zone = $curzone;
                $user->save();
                Auth::setUser($user);
                return $zonename_list[0];
            } else {
                $user = User::find(Auth::user()->id);
                $user->zone_name = $zonename_list[1];
                $user->recent_zone = $curzone;
                $user->save();
                Auth::setUser($user);
                return $zonename_list[1];
            }
        }elseif($count == 1) {
            $user = User::find(Auth::user()->id);
            $user->zone_name = $zonename_list[0];
            $user->recent_zone = $curzone;
            $user->save();
            Auth::setUser($user);
            return $zonename_list[0];
        }else {
            return 0;
        }

    }
    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2){
        $earth_radius = 6371;

        $dLat = deg2rad( $latitude2 - $latitude1 );  
        $dLon = deg2rad( $longitude2 - $longitude1 );  

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
        $c = 2 * asin(sqrt($a));  
        $d = $earth_radius * $c;  
        return $d;
    }

    public function createzone(Request $request)
    {
         $validator = Validator::make($request->all(), [
        'zonename' => 'required|max:255',
        'lat' => 'required|max:255',
        'lng' => 'required|max:255',
        'range' => 'required|max:255',
	    ]);

	    if ($validator->fails()) {
	        return redirect('/zone')
	            ->withInput()
	            ->withErrors($validator);
	    }

	    $zone = new Zone;
	    $zone->zone_name = $request->zonename;
	    $zone->latitude = $request->lat;
	    $zone->longitude = $request->lng;
	    $zone->range = $request->range;
	    $zone->save();
        \Session::flash('flash_message','"'.$request->zonename.'" Zone Created successfully.');
	    return redirect('/zones');
    }

    public function ShowZones()
    {
        $zones = Zone::orderBy('created_at', 'asc')->get();
        return view('zones', [
            'zones' => $zones
        ]);
    }

    public function deletezone(Request $request)
    {
        $id = $request->id;
        $zone = Zone::find($id);
        $zone->delete();
        \Session::flash('flash_message',$request->zonename.' Zone deleted successfully.');
        return redirect('/zones');
    }

    public function zonelist(Request $request) {
        $key = $request->key;        
        $zones = Zone::where('zone_name','like','%'.$key.'%')->get();
        return view('adminlists.zoneslist', [
            'zones' => $zones
        ]);

    }

}
