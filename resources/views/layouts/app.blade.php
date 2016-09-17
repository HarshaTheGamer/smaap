<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMAAP</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    @yield('head')
    <style>

        body {
            font-family: 'Lato';
            background: #F6F6F6 none repeat scroll 0% 0%;
        }

        .fa-btn {
            margin-right: 6px;
        }
        #main-content {
            margin-top: 50px;
        }
        .navbar-default {
            border-bottom: 3px solid #336799;
            background: rgba(255, 255, 255, 0.8) none repeat scroll 0% 0%;
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
            padding: 0px;
            transition: all 0.25s ease-in-out 0s;

        }
        .navbar { margin-bottom: 0px; }
        .panel-heading {
          background-color: #6C9 !important;
          border-radius: 5px 5px 0 0;
          color: #000 !important;
          font-size: 14px;
          padding: 10px 20px;
          text-align: center;
          text-transform: uppercase;
        }
        #profile-head {
                background: #6C9 none repeat scroll 0px 0px;
                border-radius: 8px 8px 0px 0px;
                width: 87%;
                margin-bottom: 0px;
                padding: 10px 20px;
                border-bottom: medium solid #66B999;
                color: #000 !important;
            }
        #friendlist-head {
            background: #6C9 none repeat scroll 0px 0px;
            border-radius: 8px 8px 0px 0px;
            width: 85%;
            padding: 10px 20px;
            margin-bottom: 0px;
            color: #000 !important;

        }
        #friendlist-body {
                background: #6C9 none repeat scroll 0px 0px;
                border-radius: 0px 0px 8px 8px;
                width: 85%;
                color: #000;
                height: 305px;
                overflow: auto;
                padding-left: 1px;
            }
        #profile-body {
                background: #6C9 none repeat scroll 0px 0px;
                border-radius: 0px 0px 8px 8px;
                width: 87%;
                padding: 20px;
                color: #000;
            }
        #searchFriend {
            width: 86%;
            border-bottom: 0px none;
            border-top: 0px none;
            background-color: #66B999;
            color: #000;
            height: 30px;
        }
        .Profile {
            width: 50px;
            float: left;
            height: 100%;
            margin: 0px !important; 
        }
        @yield('style')
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                         <img src='images/logo.jpg' style="width: 100px; height: 55px; margin-top: -20px;">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Home</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li><a class="getApp" href="smaapchat">Smaap Chat</a>
                     </li>
                </ul>

                @if(!Auth::guest() && Auth::user()->email == "admin@smaap.com")
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/zone') }}">Create New Zone</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/zones') }}">Zones</a></li>
                </ul>
      
                @endif

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img src='{{ Auth::user()->profile }}' style="width:32px; height:32px; border-radius:50px; position: absolute; left:-20px; top:10px;">{{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('logout1') }}" id="logout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>
</div>
<div id="main-content"  style="min-height: 100%;">
        <section id="features">
            <div class="container">
                 @if(Session::has('flash_message'))
            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
                @endif
                @if(Session::has('alert'))
                    <div class="alert alert-danger"><span class="glyphicon glyphicon-wrong"></span><em> {!! session('alert') !!}</em></div>
                @endif
                @if(Auth::check())
                @if(Auth::user()->email != "admin@smaap.com")
                <div class="row">
                    <div class="col-md-4 col-sm-4 scrollpoint sp-effect1">
                        <div class="media text-right feature" id="frequests">
                            <a class="pull-right" href="#">
                                <i class="fa fa-bell fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Friend Requests</h3>
                                See friend requests for you.
                            </div>
                        </div>
                        <div class="media text-right feature" id="likers">
                            <a class="pull-right" href="#">
                                <i class="fa fa-thumbs-up fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Likes</h3>
                                Your likers.
                            </div>
                        </div>
                        <div class="media text-right feature" id="chatroom">
                            <p class="pull-right" href="#">
                                <i class="fa fa-comments fa-2x"></i>
                            </p>
                            <div class="media-body">
                                <h3 class="media-heading">Recent Chat</h3>
                                View recent chat.
                            </div>
                        </div>
                        <div class="media text-right feature active" id="yourzone">
                            <a class="pull-right" href="#">
                                <i class="fa fa-map-marker fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Your Zone</h3>
                                See people in your zone.
                            </div>
                        </div>                        
                        <div class="media text-right feature" id="nearzones">
                            <a class="pull-right" href="#">
                                <i class="fa fa-compass fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Zones around You</h3>
                                See near by zones around you.
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-4 col-sm-4" id="page-content" >
                             @yield('content')
                    </div>
                    <div class="col-md-4 col-sm-4 scrollpoint sp-effect2">
                        <div class="media feature">
                            <p class="pull-right" href="#">
                             </p>
                            <div class="media-body">
                                <h3 class="media-heading" id="profile-head">Profile</h3>
                                    <div style="" id="profile-body">
                                        <image src='{{ \Auth::user()->profile }}' style="width:100%; height:250px; margin:auto; ">
                                        <hr>
                                        {{ \Auth::user()->userstatus }}
                                        <hr>
                                        <a href="profile">
                                            <button type="submit" class="btn btn-danger" >
                                            <i class="glyphicon glyphicon-edit"></i> Edit
                                            </button>
                                        </a>                                        
                                    </div>                            
                            </div>
                        </div>
                        <div class="media feature" id="friendslist">
                            <div class="media-body">
                                <h3 class="media-heading" id="friendlist-head">Friends List</h3>
                                 <input type="text" placeholder="Search Friends by name" id="searchFriend" > 
                                    <div style="display:none" id="friendlist-body">

                                    <div>

                            </div>
                        </div>
                       
                        </div>                
                    </div>
                        @else
                        @yield('content')
                        @endif
                    @else
                    @yield('content')
                    @endif
 
                </div>

            </div>
        </section>
 @yield('chat')
</div>
<footer>
            <div class="container">              
                <div class="rights">
                    <p>Copyright &copy; 2016</p>
                    <p>Developed by <a href="http://www.virgosys.com" target="_blank">Virgosys Softwares</a></p>
                </div>
            </div>
</footer>

    

    <!-- JavaScripts -->
   
      <script src="js/jquery-1.10.2.js"></script>
  <script src="js/jquery-ui.js"></script>
      <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
    <script src="assets/js/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/scripts.js"></script>
   @yield('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    <script type="text/javascript">

    $(document).ready(function(){
            $("#profile-head").click(function(){
                $("#profile-body").toggle('slow');
                $("#friendlist-body").toggle('slow');
            });
             $("#friendlist-head").click(function(){
                $("#friendlist-body").toggle('slow');
                $("#profile-body").toggle('slow');
            });
        });

    var page_content = document.getElementById("page-content");
    var friendlist = document.getElementById("friendlist-body");

        @if(Auth::check())
            @if(Auth::user()->email != "admin@smaap.com")
            $.ajax ({
                url: 'friends',
                method: 'get',
                data: {},
                success: function(data){
                    friendlist.innerHTML = data;
                    $("#friendlist-body").toggle('slow');
                    $("#profile-body").toggle('slow');
                         console.log("friends list updated successfully "+data);
                },
                error: function(){
                          console.log("fail to get friends");
                },
              });
            @endif
        @endif

        $("#searchFriend").keyup(function(){
            $.ajax ({
            url: 'friends',
            method: 'get',
            data: { key: $("#searchFriend").val()},
            success: function(data){
                friendlist.innerHTML = data;
                      console.log("friends list updated successfully "+data);
            },
            error: function(){
                      console.log("fail to get friends");
            },
          });

        });

    $('#myprofile').click(function(){
        window.location.href="profile";        
    });
    $('#chatroom').click(function(){
        $('.media').removeClass("active");
        $(this).addClass('active');
        window.location.href="chatroom";
    });
    $('#yourzone').click(function(){
        $('.media').removeClass("active");
        $(this).addClass('active');
        window.location.href="smaapchat";
    });
    $('#nearzones').click(function(){
        $('.media').removeClass("active");
        $(this).addClass('active');
        window.location.href="zones";
    });
    $('#frequests').click(function(){
        $('.active').removeClass("active");
        $(this).addClass('active');
        $.ajax ({
            url: 'friendrequest',
            method: 'get',
            data: {},
            success: function(data){
                page_content.innerHTML = data;
                     console.log("requests list updated successfully "+data);
            },
            error: function(){
                      console.log("fail to get requests");
            },
          });
    });
    $('#likers').click(function(){
        $('.active').removeClass("active");
        $(this).addClass('active');
        $.ajax ({
            url: 'likers',
            method: 'get',
            data: {},
            success: function(data){
                page_content.innerHTML = data;
                     console.log("likers list updated successfully "+data);
            },
            error: function(){
                      console.log("fail to get likers");
            },
          });
    });

    $('#logout').click(function(){
        QB.chat.disconnect();
    })


    </script>
      
</body>
</html>
