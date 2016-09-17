@extends('layouts.app')
@section('style')
.info {
  background: #e5e5e5;
  border-radius: 50%;
  display: inline-block;
  height: 20px;
  line-height: 20px;
  margin: 0 10px 0 0;
  text-align: center;
  width: 20px;
}
.loginpanel {
  width:300px;
  margin: auto;
  margin-top: 50px;
}
footer {
  position: fixed;
bottom: 0px;
left: 0px;
right: 0px;
}
body {
  background: #F6F6F6 none repeat scroll 0% 0%;
}
@endsection

@section('content')
 <div class="panel panel-default loginpanel">
                <div class="panel-heading">Login</div>
                <div class="panel-body" style="padding: 25px;">
                  <!--                         @if(count($errors))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li> {{ $error }} </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif -->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/handleLogin') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control" placeholder="Password" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                              <span class="info">?</span><a href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                                <button type="submit" class="btn btn-primary" style="float: right;">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>
                        </div>
                    </form>
                </div>
            </div>
@endsection
@section('scripts')

@endsection
