@extends('layouts.app')
@section('style')

.regpanel {
    max-width: 600px;
    margin: auto;
    margin-top: 50px;
}

.email {
    margin-top: -25px;
    position: absolute;
    right: 20px;
}
.name {
    margin-top: -25px;
    position: absolute;
    right: 20px;
}

body {
  background: #F6F6F6 none repeat scroll 0% 0%;
}
@endsection

@section('content')
            <div class="panel panel-default regpanel">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/handleregister') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
                                <span id="nameavailable" style="display:none; color:green;" class="fa fa-check name"></span>
                                <span id="namenot-available" style="display:none; color:red;" class="fa fa-close">  Email already exists</span>
                                <span id="wrongname" style="display:none; color:red;" class="fa fa-close name"></span>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                                <span id="available" style="display:none; color:green;" class="fa fa-check email"></span>
                                <span id="not-available" style="display:none; color:red;" class="fa fa-close">  Email already exists</span>
                                <span id="wrong" style="display:none; color:red;" class="fa fa-close email"></span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="Password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" placeholder="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <label for="birthday" class="col-md-4 control-label">Birthday</label>

                            <div class="col-md-6">
                                <input id="Birthday" placeholder="yyyy-mm-dd" type="date" class="form-control" name="birthday" readonly>

                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="birthday" class="col-md-4 control-label">Gender</label>

                            <div class="col-md-6">
                                <input type="radio" name="gender" value="male" checked> Male<br>
                                <input type="radio" name="gender" value="female"> Female<br>

                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6">
                                <input id="Phone" type="tel" class="form-control" placeholder="Phone number" name="phone">

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" style="float: right;">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
@endsection
@section("scripts")
     <script>
      $(function() {
        
        $( "#Birthday" ).datepicker({
              changeMonth: true,
              changeYear: true,
              minDate: "-61Y", 
              maxDate: "-16Y"
            }); 
        $( "#Birthday" ).datepicker("option", "dateFormat", 'yy-mm-dd');
        $( "#Birthday" ).datepicker( "option", "showAnim", 'slide' );

        $( "#email" ).change(function() {
          var email = $( this ).val();
          $.ajax ({
            url: 'checkemail',
            method: 'post',
            data: { email: email,_token: $('input[name="_token"]').val()},
            success: function(data){
                if (data == "pass") {
                    $('#available').show();
                    $('#not-available').hide();
                    $('#wrong').hide();
                }
                if(data == "wrong") {
                    $('#wrong').show();                    
                    $('#not-available').hide();
                    $('#available').hide();
                } 
                if(data != "pass" && data !="wrong") {
                    $('#wrong').hide();                    
                    $('#not-available').show();
                    $('#available').hide();
                }
                
            },
            error: function(){
               console.log("error");
            },
          });
        });
        $( "#name").change(function() {
          var name = $( this ).val();

          $.ajax ({
            url: 'checkname',
            method: 'post',
            data: { name: name,_token: $('input[name="_token"]').val()},
            success: function(data){
                if (data == "pass") {
                    $('#nameavailable').show();
                    $('#namenot-available').hide();
                    $('#wrongname').hide();
                }
                if(data == "wrong") {
                    $('#wrongname').show();                    
                    $('#namenot-available').hide();
                    $('#nameavailable').hide();
                } 
               
            },
            error: function(){
               console.log("error");
            },
          });
        });

      });
  </script>
@endsection


