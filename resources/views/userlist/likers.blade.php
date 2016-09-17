            @if(isset($alikers))
             <div class="panel panel-default" id="alikerspanel">
                @if(count($alikers)>1)
                <div class="panel-heading">{{ count($alikers) }} anonymously likes Your Profile</div>
                @endif
                @if(count($alikers)==1)
                <div class="panel-heading">{{ count($alikers) }} anonymously like Your Profile</div>
                @endif
            </div>
               @endif
            @if(isset($likers))
             <div class="panel panel-default" id="likerspanel">
                @if(count($likers)>1)
                <div class="panel-heading">{{ count($likers) }} likes Your Profile</div>
                @endif
                @if(count($likers)==1)
                <div class="panel-heading">{{ count($likers) }} like Your Profile</div>
                @endif
                    <div class="panel-body">

                        <table class="table table-striped user-table">

                                    <tbody>
                                        @foreach ($likers as $liker)
                                            @foreach ($liker as $user)
                                                @if($user->name != \Auth::user()->name)
                                                <tr>
                                                    <!-- user Name -->
                                                    <td class="table-text">
                                                        <form action="{{ url('ViewUserProfile') }}" method="GET">
                                                        <!-- {{ csrf_field() }} -->
                                                        <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                                        <input type="hidden" name="user2" value="{{ $user->id }}">

                                                        <button type="submit" class="" style="width:100%;">
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

                                                </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @if(isset($nolikes))
                <div class="panel panel-default" id="alikerspanel">
                    <div class="panel-heading"> No one seem to be liked you yet</div>
                </div>
                @endif
