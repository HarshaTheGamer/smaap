
@extends('layouts.app')

@section('content')
            <div class="panel panel-default">
              @if(isset($user2profile))
               @foreach ($user2profile as $up)
                <div class="panel-heading"><h3>Profile of Anonymous </h3><span id="likecount">{{ \App\Like::where('user_two',$up->id)->count() }}</span>&nbsp&nbsp<span class="glyphicon glyphicon-thumbs-up"></span></div>

                <div class="panel-body">
                  <input type="hidden" name="likestat" value="{{ \App\Like::where('user_two',$up->id)->where('user_one',Auth::user()->id)->count() }}">
                  <!-- <button class="btn btn-default unlike" style="float:right;"><span class="glyphicon glyphicon-thumbs-down"></span> unLike</button> -->
                  <p class="unlike" style="float:right;"> You Like this profile </p>
                      <button class="btn btn-default alike" style="float:right;"><span class="glyphicon glyphicon-thumbs-up"></span> Like Anonymously</button>
                      <button class="btn btn-default like" style="float:right;"><span class="glyphicon glyphicon-thumbs-up"></span> Like</button>
                      
                    <image src='default.jpg' style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px; "> 
                               
                               {{ $up->birthday }} <br><br>

                               {{ $up->gender }}<br><br>
                                        
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
                            <form action="{{ url('sendfrequest') }}" method="POST" style="float:right;">
                                {{ csrf_field() }}
                                <input name="user2" value="{{ $up->id }}" type="hidden">
                                <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                <button type="submit" class="btn btn-success" >
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
                            <form action="chatroom" method="GET">
                                <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="user2" value="{{ $up->id }}">
                                <button type="submit" class="btn btn-default btn-success">
                                    <i class="fa fa-envelope"></i> Chat
                                </button>
                            </form>
                            <form action="{{ url('unfriend') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="user2" value="{{ $up->id }}">
                                <button type="submit" class="btn btn-default" style="float:right" disabled>
                                    <i class="fa fa-trash"></i> Unfriend
                                </button>
                            </form>
                      @endif
                  </div>
                 @endforeach
               @endif
            </div>
@endsection
@section('style')
.AcceptReject { display: inline; }
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
@endsection