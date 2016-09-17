
                            @if(isset($friends))
                            @if(count($friends)>0)

                                        @foreach ($friends as $friend)
                                            @foreach ($friend as $fr)

                                                        <form action="{{ url('ViewUserProfile') }}" method="GET">
                                                            <input type="hidden" name="user1" value="{{ Auth::user()->id }}">
                                                            <input type="hidden" name="user2" value="{{ $fr->id }}">

                                                            <button type="submit" class="" style="width: 100%; background: transparent none repeat scroll 0% 0%; padding: 0px; border-width: 0px 0px 1px; border-style: none none dotted; border-color: -moz-use-text-color -moz-use-text-color rgb(0, 0, 0); -moz-border-top-colors: none; -moz-border-right-colors: none; -moz-border-bottom-colors: none; -moz-border-left-colors: none; border-image: none;">
                                                                <div style="float:left">
                                                                            <img src='{{ $fr->profile }}' class="Profile">
                                                                            </div>
                                                                            <div style="float: left; padding: 15px;">{{ $fr->name }}</div>
                                                                            @if($fr->online == 1)
                                                                                <span style="color:green; float: right; margin: 15px;">online</span>
                                                                            @else
                                                                                <span style="color:grey; float: right; margin: 15px;">offline</span>
                                                                            @endif

                                                                
                                                            </button>
                                                        </form>                                               

                                            @endforeach
                                        @endforeach

                            @endif
                            @else

                            <p>You dont have any friends yet</p>
                            @endif
