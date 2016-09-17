                            <div class="panel-body">
                                <table class="table table-striped user-table">

                                    <tbody>
                                    @if(count($zoneusers) !=0)
                                        @foreach ($zoneusers as $user)
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
                                                               
                                                        </div>
                                                    </button>
                                                </form>
                                                    
                                                </td>

                                            </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <p> No users found in your zone </p>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>