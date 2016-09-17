
@extends('layouts.app')
@section('style')
    .Profile { width: 50px;
            float: left;
            height: 100%;
            margin: 0px !important; 
        }
    .AcceptReject { display: inline; }
        #zoneuserspanel {
            max-height: 450px;
            overflow: auto;
        }
@endsection

@section('content')
@if(!empty(\Auth::user()->zone_name))

@else

@endif

<!--         @if(Session::has('flash_message'))
            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
        @endif -->
<!-- All Users Panel -->
                   {{ csrf_field() }}
                        <div class="panel panel-default" id="homepanel">
                            @if(\Auth::user()->email != "admin@smaap.com")
                            <div class="panel-heading">
                                Your Zone
                            </div>
                            
                            <div class="panel-body">
                                <table class="table table-striped user-table">

                                    <tbody>
                                        <div class="img-place"><img src="chat/images/ajax-loader.gif" id="load-users"></div>

                    <p id="zonenamepanel"></p>
                    <div id="zoneuserspanel" ></div>


                                    </tbody>
                                </table>
                            </div>
                            @endif
                    @if(\Auth::user()->email == "admin@smaap.com")
                        @if (count($users) > 0)
                            <div class="panel-heading">
                                Smaap users
                            </div>

                            <div class="panel-body">
                                <table class="table table-striped user-table">

                                    <tbody>
                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                Registered
                                            </th>
                                            <th>
                                                Last Login/Logout activity
                                            </th>
                                        </tr>


                                        @foreach ($users as $user)
                                            @if($user->name != \Auth::user()->name)
                                            <tr>
                                                <!-- user Name -->
                                                <td class="table-text">
                                                    <form action="{{ url('ViewUserProfile') }}" method="GET">
                                                    <!-- {{ csrf_field() }} -->
                                                    <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="user2" value="{{ $user->id }}">

                                                    <button type="submit" class="" style="width: 100%; border: medium none;">
                                                        <div>
                                                                    <img src='{{ $user->profile }}' class="Profile">
                                                                    {{ $user->name }}
                                                                @if($user->zone_name)
                                                                    <span style="color:green; float: right">online</span>
                                                                @else
                                                                    <span style="color:grey; float: right">offline</span>
                                                                @endif
                                                                </div>
                                                    </button>
                                                </form>
                                                    
                                                </td>
                                                <td class="table-text"><p>

                                                    <?php 
                                                    $now = new DateTime();                                                    
                                                    $to_time = strtotime("$user->created_at");
$from_time = strtotime($now->format('Y-m-d H:i:s'));
$seconds =  round(abs($to_time - $from_time));
$dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    echo $dtF->diff($dtT)->format('%a days, %h hours ago');
?></p></td>
                                                                                                                        
                                                
                                                <td class="table-text"><p><?php 
                                                    $now = new DateTime();                                                    
                                                    $to_time = strtotime("$user->updated_at");
$from_time = strtotime($now->format('Y-m-d H:i:s'));
$seconds =  round(abs($to_time - $from_time));
$dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    echo $dtF->diff($dtT)->format('%a days, %h hours ago');
?></p></td>
                                                                                                                        
                                                


                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        @endif
                        </div>
                    
@endsection
@section('scripts')
@if(\Auth::user()->email != "admin@smaap.com")
@if(Session::has('new_reg'))
@endif
<script src="chat/js/quickblox.min.js"></script>
<script src="chat/js/config.js"></script>
<script type="text/javascript">
$('.active').removeClass("active");
$('#yourzone').addClass('active');
  $(document).ready(function() {
    QB.createSession(function(err,result){
        console.log('Session create callback', err, result);

          var email = "{{ Auth::user()->email }}";
          var password = "{{ Auth::user()->email }}" ;

          var params = { 'email': email, 'password': password};

          QB.users.create(params, function(err, user){
            if (user) {
              console.log(user);
              var user_id = user.id;
              $.ajax ({
                url: 'updateChatId',
                method: 'post',
                data: { user_email: email, chat_id: user_id, _token: $('input[name="_token"]').val()},
                success: function(data){
                         console.log("chat id updated for "+data);
                },
                error: function(){
                          console.log("fail to update chat id");
                },
              });
              updateprofile(user_id);
            } else  {
              console.log("fail1");
            }
          });
      });
    function updateprofile(user_id) {
          var email = "{{ Auth::user()->email }}";
          var password = "{{ Auth::user()->email }}" ;

          var params = { 'email': email, 'password': password};
          QB.login(params, function(err, user){
                  if (user) {
                    QB.users.update(user_id, {full_name: "{{ Auth::user()->name }}", email: "{{ Auth::user()->email }}"}, function(err, user){
                      if (user) {
                         console.log(user);
                      } else  {
                         console.log(fail+err);
                      }
                    });
                    
                  } else  {
                    // error
                  }
                });
        }
});
</script>

<script type="text/javascript">
$('#load-users').hide();
var x = document.getElementById("zonenamepanel");
var y = document.getElementById("zoneuserspanel");
@if(!empty(\Auth::user()->zone_name))
x.innerHTML = "Your Current Zone : '{{\Auth::user()->zone_name}}'";
getusers();
setInterval(function() {
  // method to be executed;
  getusers();
}, 15000);

@else
getLocation();
@endif

function getLocation() {
    $('#load-users').show();
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);

    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    
    var lat= position.coords.latitude;
    var lng= position.coords.longitude;
    $.ajax ({
            url: 'currentLatLng',
            method: 'post',
            data: { lat: lat, lng: lng, _token: $('input[name="_token"]').val()},
            success: function(data){
                x.innerHTML = "Your Current Zone :" + data;
                     console.log("zone updated successfully "+data);
                     getusers();
            },
            error: function(){
                      console.log("fail to update zone");
            },
          });
    $('#load-users').hide();
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation, please try in other browser."
            $('#load-users').hide();
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable in this device please try in other device or browser."
            $('#load-users').hide();
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out, refresh the page and try again."
            $('#load-users').hide();
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred please try in other device or browser."
            $('#load-users').hide();
            break;
    }
}

function getusers() {
    $.ajax ({
            url: 'getzoneusers',
            method: 'post',
            data: { _token: $('input[name="_token"]').val()},
            success: function(data){
               y.innerHTML = data;
            },
            error: function(){
                y.innerHTML = "You are not in any zone(Turn on your gps)";
            },
          });

}
@endif
</script>
@endsection
