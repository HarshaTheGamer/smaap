
@extends('layouts.app')

@section('content')
            <div class="panel panel-default">
              @if(isset($user2profile))
               @foreach ($user2profile as $up)
                <div class="panel-heading"><span id="user2_name">{{ $up->name }}</span><span id="likecount">{{ \App\Like::where('user_two',$up->id)->count() }} <span class="glyphicon glyphicon-thumbs-up"></span></span></div>

                <div class="panel-body">
                  <p id="user2_email">{{$up->email}}</p>
                  <image src='{{ $up->profile }}' style="width:100%; height:300px;"> 
                  <div id="userstatus">
                    <h5>STATUS</h5><hr style="margin:0px;">
                    <p>{{$up->userstatus}}</p>
                  </div>
                  <input type="hidden" name="likestat" value="{{ \App\Like::where('user_two',$up->id)->where('user_one',Auth::user()->id)->count() }}">
                  @if(Auth::user()->email != "admin@smaap.com")
                  <!-- <button class="btn btn-default unlike" style="float:right;"><span class="glyphicon glyphicon-thumbs-down"></span> unLike</button> -->
                  <p class="unlike" style="float:right;"> You Like this profile </p>
                      <button class="btn btn-default alike" style="float:right; margin: 3px;"><span class="glyphicon glyphicon-thumbs-up"></span> Like Anonymously</button>
                      <button class="btn btn-default like" style="float:right; margin: 3px;"><span class="glyphicon glyphicon-thumbs-up"></span> Like</button>
                  @endif
                               
                    @if(Auth::user()->email != "admin@smaap.com")               
                      @if($status==0)                     
                         @if($request==1)                    
                          <form action="{{ url('cancelfriendrequest') }}" method="POST">
                              {{ csrf_field() }}
                              <input name="user2" value="{{ $up->id }}" type="hidden">
                              <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                              <input type="hidden" name="cancelrequest" value="cancel">
                              <button type="submit" class="btn btn-danger">
                                <i class="fa fa-child"></i> Cancel Friend Request
                              </button>
                          </form>
                          <div class="alert alert-success pull-right">
                                Friend Request Sent
                          </div>
                          @elseif($request==0) 
                            <form action="{{ url('sendfrequest') }}" method="POST" style="float:right; margin: 10px 0px;">
                                {{ csrf_field() }}
                                <input name="user2" value="{{ $up->id }}" type="hidden">
                                <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-child"></i> Send Friend Request
                                 </button>
                            </form>                          
                          @elseif($request==2)
                          <form action="{{ url('acceptfr') }}" method="POST" class="AcceptReject">
                              {{ csrf_field() }}
                             <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                             <input type="hidden" name="user2" value="{{ $up->id }}">
                             <input type="hidden" name="status" value="1">
                             <button type="submit" class="btn btn-success"> Accept </button>
                          </form>
                          <form action="{{ url('rejectfr') }}" method="POST" class="AcceptReject">
                              {{ csrf_field() }}
                              <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                              <input type="hidden" name="user2" value="{{ $up->id }}">
                              <input type="hidden" name="status" value="2">
                              <button type="submit" class="btn btn-danger"> Reject </button>
                          </form>
                          @endif
                      @elseif($status==1)
                            <form action="#" method="GET">
                                <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="user2" value="{{ $up->id }}">
                                <button type="submit" class="btn btn-default btn-success" id="chat">
                                    <i class="fa fa-envelope"></i> Chat
                                </button>
                            </form>
                            <form action="{{ url('unfriend') }}" method="POST" id="unfriend" onsubmit="return confirm('Are you sure you want to unfriend '+document.getElementById('user2_name').innerHTML);">
                                {{ csrf_field() }}
                                <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="user2" value="{{ $up->id }}">
                                <button type="submit" class="btn btn-default" style="float:right">
                                    <i class="fa fa-bolt"></i> unfriend
                                </button>
                            </form>
                      @endif
                      @endif
                  </div>
                 @endforeach
               @endif
            </div>

@endsection
@section('style')
.AcceptReject { display: inline; }
#likecount{ float: right; }
@endsection

@section('scripts')
<script type="text/javascript">

    $(document).ready(function() {
      $likestat=$('input[name="likestat"]').val();
      if ($likestat==1) {
                    $('.alike').hide();
                    $('.like').hide();
                    $('.unlike').show();
    }
    else {
        $('.unlike').hide();
        $('.like').show();
        $('.alike').show();
    }


        $('.like').click(function(){

         $.ajax({
                url: 'like',
                method: 'post',             
                data: {user1: $('input[name="user1"]').val(),user2: $('input[name="user2"]').val(), _token: $('input[name="_token"]').val()},
                success: function(data){

                    $('#likecount').text(data['lc']);
                    $('.like').hide();
                    $('.alike').hide();
                    $('.unlike').show();
                    if (data['likematch']=="true") {
                      alert('Like match!!! now you are friend of me');
                      window.location.href = "home";
                    };
                    
                },
                error: function(){},
            })
              .done(function(){
                
              });                  
           
        });
        $('.alike').click(function(){

         $.ajax({
                url: 'alike',
                method: 'post',             
                data: {user1: $('input[name="user1"]').val(),user2: $('input[name="user2"]').val(), _token: $('input[name="_token"]').val()},
                success: function(data){

                    $('#likecount').text(data);
                    $('.like').hide();
                    $('.alike').hide();
                    $('.unlike').show();
                },
                error: function(){},
            })
              .done(function(){
                
              });                  
           
        });
        $('.unlike').click(function(){

         $.ajax({
                url: 'unlike',
                method: 'post',             
                data: {user1: $('input[name="user1"]').val(),user2: $('input[name="user2"]').val(), _token: $('input[name="_token"]').val()},
                success: function(data){

                    $('#likecount').text(data);
                    $('.unlike').hide();
                    $('.like').show();
                    $('.alike').show();
                },
                error: function(){},
            })
              .done(function(){
                
              });                  
           
        });         
    });
</script>
<script src="chat/js/quickblox.min.js"></script>
<script src="chat/js/config.js"></script>
<script type="text/javascript">
  $(document).ready(function() {

        QB.createSession(function(err,result){
        console.log('Session create callback', err, result);
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
                         createprofile();
                      } else  {
                         console.log(fail+err);
                         createprofile();
                      }
                    });
                    
                  } else  {
                    // error
                  }
                });
        }
        function updateprofile2(user_id) {
          var email = $('#user2_email').text();
          var password = $('#user2_email').text();

          var params = { 'email': email, 'password': password};
           QB.login(params, function(err, user){
                    if (user) {
                       QB.users.update(user_id, {full_name: $('#user2_name').text(), email: email}, function(err, user){
                        if (user) {
                           console.log(user);
                           window.location.href = "chatbox?"+user_id;
                        } else  {
                           console.log(fail+err);
                        }
                      });
                      
                    } else  {
                      // error
                    }
                  });
        }
        function createprofile() {

        var email = $('#user2_email').text();
        var password = $('#user2_email').text();

        var params = { 'email': email, 'password': password};
        var userparams = {filter: { field: 'email', param: 'eq', value: email }};

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
             updateprofile2(user_id);
          } else  {
            console.log("fail2");
            if (err.code == 422) {
                QB.login(params, function(err, user){
                    if (user) {
                      var user_id = user.id;
                      console.log(user.id);
                      console.log(user_id);
                      window.location.href = "chatbox?chatuser="+user_id;
                    }else {
                      console.log("something went wrong");
                    }
                  });             
            }

          }
        });

      }

    $('#chat').on('click', function() {

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
          createprofile();
        }
      });
            
    });
});



</script>
@endsection
