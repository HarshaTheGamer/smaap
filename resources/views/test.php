@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              @if(isset($user2profile))
               @foreach ($user2profile as $up)
                <div class="panel-heading"><h3>Profile of {{ $up->name }} </h3></div>

                <div class="panel-body">
                    <image src='{{ $up->profile }}' style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px; "> 
                               
                               {{ $up->birthday }} <br><br>
                               {{ $up->email }} <br><br>
                               {{ $up->gender }}<br><br>
                                   
                                    
                                    @if (isset($status))
                                            @if($rstatus==0 )
                                              <form action="{{ url('friendrequest') }}" method="POST">
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

                                            @elseif($rstatus==1)
                                              <button type="button" class="btn btn-success">
                                                  <i class="fa fa-child"></i> Send Message
                                              </button>
                                               <form action="{{ url('unfriend') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                                <input type="hidden" name="user2" value="{{ $up->id }}">
                                                <button type="submit" class="btn btn-default" style="float:right">
                                                    <i class="fa fa-trash"></i> Unfriend
                                                </button>
                                            </form>
                                            @elseif($rstatus==2)
                                              <form action="{{ url('friendrequest') }}" method="POST" style="float:right;">
                                                {{ csrf_field() }}
                                                <input name="user2" value="{{ $up->id }}" type="hidden">
                                                <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-child"></i> Send Friend Request
                                                </button>
                                            </form>
                                            @endif
                                    @elseif(isset($hrequest))
                                          @if($hrequest!=0 && $hstatus==0)

                                          <form action="{{ url('ViewUserProfile') }}" method="POST" class="AcceptReject">
                                                {{ csrf_field() }}
                                              <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                              <input type="hidden" name="user2" value="{{ $up->id }}">
                                              <input type="hidden" name="status" value="1">
                                              <button type="submit" class="btn btn-success"> Accept </button>
                                          </form>
                                           <form action="{{ url('ViewUserProfile') }}" method="POST" class="AcceptReject">
                                                 {{ csrf_field() }}
                                                <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                                <input type="hidden" name="user2" value="{{ $up->id }}">
                                                <input type="hidden" name="status" value="2">
                                                 <button type="submit" class="btn btn-danger"> Reject </button>
                                           </form>
                                          @elseif($hstatus == 1)
                                          <button type="button" class="btn btn-success">
                                                  <i class="fa fa-child"></i> Send Message
                                              </button>
                                               <form action="{{ url('unfriend') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                                <input type="hidden" name="user2" value="{{ $up->id }}">
                                                <button type="submit" class="btn btn-default" style="float:right">
                                                    <i class="fa fa-trash"></i> Unfriend
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ url('friendrequest') }}" method="POST" style="float:right;">
                                              {{ csrf_field() }}
                                              <input name="user2" value="{{ $up->id }}" type="hidden">
                                              <input type="hidden" name="user1" value="{{ Auth::user()->id }}">

                                              <button type="submit" class="btn btn-success">
                                                  <i class="fa fa-child"></i> Send Friend Request
                                              </button>
                                          </form>
                                          @endif
                                    @elseif(isset($sfstatus))
                                      @if($sfstatus == 1)
                                      <form action="{{ url('chatroom') }}" method="POST">
                                          {{ csrf_field() }}
                                          <input name="id" value="{{ $up->id }}" type="hidden">

                                          <button type="button" class="btn btn-success">
                                              <i class="fa fa-envelope"></i> Send Message
                                          </button>
                                      </form>
                                      <form action="{{ url('chatroom') }}" method="POST">
                                          {{ csrf_field() }}
                                          <input name="id" value="{{ $up->id }}" type="hidden">

                                          <button type="button" class="btn btn-default" style="float:right">
                                              <i class="fa fa-trash"></i> Unfriend
                                          </button>
                                      </form>
                                      @else
                                      <form action="{{ url('friendrequest') }}" method="POST" style="float:right;">
                                        {{ csrf_field() }}
                                        <input name="user2" value="{{ $up->id }}" type="hidden">
                                        <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                        <!-- <button type="button" class="btn btn-success send-btn"> -->
                                            <!-- <i class="fa fa-child"></i> Test Send Friend Request -->
                                        <!-- </button> -->

                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-child"></i> Send Friend Request
                                        </button>
                                    </form>
                                      @endif
                                    @else
                                     <form action="{{ url('friendrequest') }}" method="POST" style="float:right;">
                                        {{ csrf_field() }}
                                        <input name="user2" value="{{ $up->id }}" type="hidden">
                                        <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                        <!-- <button type="button" class="btn btn-success send-btn"> -->
                                            <!-- <i class="fa fa-child"></i> Test Send Friend Request -->
                                        <!-- </button> -->

                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-child"></i> Send Friend Request
                                        </button>
                                    </form>
                                    @endif


                </div>
               @endforeach
               @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('style')
.AcceptReject { display: inline; }
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
  $('.send-btn').click(function(){            
    $.ajax({
      url: 'friendrequest',
      type: "post",
      data: {'email':$('input[name=user2]').val(), '_token': $('input[name=_token]').val()},
      success: function(data){
        alert(data);
      }
    });      
  }); 
});
</script>
@endsection
<?php
// ACCEPT OR REJECT Friend Request
        if (isset($request->status)) {
            if ($request->status == 1) {
                DB::table('friends')
                ->where('user_one', $user2)
                ->where('user_two', $user1)
                ->update(array('status'=>1));
                $statusfriends = DB::table('friends')
                    ->select('status','request_count','reject_count')
                    ->where(array('user_one' => $user2, 'user_two' => $user1))->get();
                foreach ($statusfriends as $statusfriend) {
                    $sfstatus=$statusfriend->status;
                    $sfrequest=$statusfriend->request_count;
                    $sfreject=$statusfriend->reject_count;
                 }
                return view('userprofile', [
                    'user2profile' => $user2profile,
                    'sfstatus' => $sfstatus,
                ]);
            }
            elseif ($request->status == 2) {
                DB::table('friends')
                ->where('user_one', $user2)
                ->where('user_two', $user1)
                ->update(array('status'=>2));
                $statusfriends = DB::table('friends')
                    ->select('status','request_count','reject_count')
                    ->where(array('user_one' => $user2, 'user_two' => $user1))->get();
                foreach ($statusfriends as $statusfriend) {
                    $sfstatus=$statusfriend->status;
                    $sfrequest=$statusfriend->request_count;
                    $sfreject=$statusfriend->reject_count;
                 }
                return view('userprofile', [
                    'user2profile' => $user2profile,
                    'sfstatus' => $sfstatus,
                ]);
            }

        }
// Selecting user on home page
        $requeststatus = DB::table('friends')
            ->select('status','request_count','reject_count')
            ->where(array('user_one' => $user1, 'user_two' => $user2))->get();
        $hasrequest = DB::table('friends')
            ->select('status','request_count','reject_count')
            ->where(array('user_one' => $user2, 'user_two' => $user1))->get();

        if (count($requeststatus)==1) {
            
            foreach ($requeststatus as $rqstatus) {
                $rstatus=$rqstatus->status;
                $rrequest=$rqstatus->request_count;
                $rreject=$rqstatus->reject_count;
             }
             if($rstatus==0 && $rrequest==1 && $rreject==0) {
                return view('userprofile', [
                'user2profile' => $user2profile,
                'rstatus' => $rstatus
                ]);
             }
             elseif($rstatus==2) {
                 return view('userprofile', [
                'user2profile' => $user2profile,
                'rstatus' => $rstatus
                ]);
             }
             elseif($rstatus==1) {
                return view('userprofile', [
                'user2profile' => $user2profile,
                'rstatus' => $rstatus
                ]);
             }          
        }

        elseif (count($hasrequest)>=1) {
            foreach ($hasrequest as $hqstatus) {
                $hstatus=$hqstatus->status;
                $hrequest=$hqstatus->request_count;
                $hreject=$hqstatus->reject_count;
             }
            return view('userprofile', [
                'user2profile' => $user2profile,
                'hrequest' => $hrequest,
                'hstatus' => $hstatus,

            ]);
        }
        else {