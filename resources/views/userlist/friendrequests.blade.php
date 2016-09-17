       <!-- Friend Request Panel -->
@if(\Auth::user()->email != "admin@smaap.com")
                        <div class="panel panel-default" id="RequestPanel">
                        
                            <div class="panel-heading">
                                Friend Requests
                            </div>

                            <div class="panel-body">
                                <table class="table table-striped user-table">

                                    <tbody>
                                        @if($hasfriendrequest == 1)
                                        @foreach ($frequests as $frequest)
                                            @foreach ($frequest as $fr)
                                                <tr>
                                                    <!-- user Name -->
                                                    <td class="table-text">
                                                        <form action="{{ url('ViewUserProfile') }}" method="GET">
                                                            <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                                            <input type="hidden" name="user2" value="{{ $fr->id }}">

                                                            <button type="submit" class="" style="width:100%;">
                                                                <div>
                                                                            <img src='{{ $fr->profile }}' class="Profile">
                                                                            {{ $fr->name }}

                                                                </div>
                                                            </button>
                                                        </form>
                                                        <form action="{{ url('rejectfr') }}" method="POST" class="AcceptReject">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                                            <input type="hidden" name="user2" value="{{ $fr->id }}">
                                                            <input type="hidden" name="status" value="2">

                                                            <button type="submit" class="btn btn-danger"> Reject </button>
                                                        </form>
                                                        <form action="{{ url('acceptfr') }}" method="POST" class="AcceptReject">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                                            <input type="hidden" name="user2" value="{{ $fr->id }}">
                                                            <input type="hidden" name="status" value="1">

                                                            <button type="submit" class="btn btn-success"> Accept </button>
                                                        </form>                                                    
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        @else
                                        <p>No friend Requests</p>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                @endif 
