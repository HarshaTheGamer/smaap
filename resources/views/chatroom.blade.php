@extends('layouts.app')
@section('head')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="chat/libs/stickerpipe/css/stickerpipe.min.css">
  <link rel="stylesheet" href="chat/css/style.css">
@endsection
@section('style')
  #features {
    display:none;
  }
  #messages-list {
    min-height: 449px;
    border: 1px solid #DDD;
  }
  #loadingo {
   position: absolute;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: white;
        z-index:1001;
        -moz-opacity: 0.8;
        opacity:.80;
        filter: alpha(opacity=80);
  }
  #loading-image {
    position: absolute;
    z-index: 1001;
    left: 40%;
    right: 0px;
    opacity: 0.8;
    top: 40%; 
  }
@endsection
@section('chat')
  <!-- Main block -->
  <div class="container">
    <div id="main_block">
        <div class="panel panel-primary">
          <div class="panel-body">
            <div class="row">
              {{ csrf_field() }}
              <div class="col-md-4">
                <div class="list-header">
                  <h4 class="list-header-title">Recent</h4>
                </div>
                <div class="list-group pre-scrollable nice-scroll" id="dialogs-list">
                <!-- list of chat dialogs will be here -->
                </div>
              </div>
                <div id="mcs_container" class="nice-scroll">
                  <div id="loadingo">
                    <img src='images/loading1.gif' id="loading-image">
                  </div>
                      
                  <div class="customScrollBox">
                    <div class="container del-style">
                      <div class="content list-group pre-scrollable nice-scroll" id="messages-list">
                        <!-- list of chat messages will be here -->
                      </div>
                    </div>
                  </div>
                    <div><img src="/chat/images/ajax-loader.gif" class="load-msg"></div>
                    <form class="form-inline" role="form" method="POST" action="" onsubmit="return submit_handler(this)">
	                  <div class="input-group">
		                  <span class="input-group-btn input-group-btn_change_load">
			              <input id="load-img" type="file">
			                <button type="button" id="attach_btn" class="btn btn-default" onclick="$('#load-img').click();">
				              <i class="icon-photo"></i>
			                </button>
		                  </span>
		                  <span class="input-group-btn input-group-btn_change_load" style="display:none;">
			                <button type="button" id="stickers_btn" class="btn btn-default" onclick="">
				              <i class="icon-sticker"></i>
			                </button>
		                  </span>

		                  <span class="input-group-btn" style="width: 100%;">
			                 <input type="text" class="form-control" id="message_text">
		                  </span>
                      @if(Auth::check())
		                  <span class="input-group-btn">
			                <button  type="submit" id="send_btn" class="btn btn-default" onclick="clickSendMessage()">Send</button>
		                  </span>
                      @endif
	                    </div>
                      <img src="/chat/images/ajax-loader.gif" id="progress">
                    </form>
                   <!--  <h4 class="list-header-title"><a href="#" onclick="showNewDialogPopup()">Add Friends for chat</a></h4> -->
                </div>
               
              </div>
            </div>
          </div>
        </div>

    </div>


    <!-- Modal (new dialog)-->
    <div id="add_new_dialog" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Choose friend to create chat</h3>
          </div>
          <div class="modal-body">
            <div class="list-group pre-scrollable for-scroll">
              <div id="users_list" class="clearfix"></div>
            </div>
            <div class="img-place"><img src="/chat/images/ajax-loader.gif" id="load-users"></div>
              <input type="text" class="form-control" id="dlg_name" placeholder="Enter dialog name">
            <button id="add-dialog" type="button" value="Confirm" id="" class="btn btn-success btn-lg btn-block" onclick="createNewDialog()">Create chat</button>
            <div class="progress">
              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal (update dialog)-->
    <div id="update_dialog" class="modal fade row" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Dialog info</h3>
          </div>
          <div class="modal-body">
            <div class="col-md-12 col-sm-12 col-xs-12 new-info">
              <h5 class="col-md-12 col-sm-12 col-xs-12">Name:</h5>
              <input type="text" class="form-control" id="dialog-name-input">
            </div>
            <h5 class="col-md-12 col-sm-12 col-xs-12 push">Add more user (select to add):</h5>
            <div class="list-group pre-scrollable occupants" id="push_usersList">
              <div id="add_new_occupant" class="clearfix"></div>
            </div>
            <h5 class="col-md-12 col-sm-12 col-xs-12 dialog-type-info"></h5>
            <h5 class="col-md-12 col-sm-12 col-xs-12" id="all_occupants"></h5>
            <button id="update_dialog_button" type="button" value="Confirm" id="" class="btn btn-success btn-ms btn-block"
              onclick="onDialogUpdate()">Update</button>
            <button id="delete_dialog_button" type="button" value="Confirm" id="for_width" class="btn btn-danger btn-ms btn-block"
              onclick="onDialogDelete()">Delete dialog</button>
          </div>
        </div>
      </div>
      </div>
@endsection

@section('scripts')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.0/jquery.nicescroll.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.4.1/jquery.timeago.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js" type="text/javascript"></script>
  <script type="text/javascript">
  
  $(document).ready(function() {
    $('.dropdown').click(function() {
      if ($('.dropdown').hasClass("open")) {
        $('.dropdown').removeClass("open");
      } else {
        $('.dropdown').addClass("open");
      }

    });
    
});
  var QBUser1 = {       

          name: '{{ \Auth::user()->name}}',
          login: '{{ \Auth::user()->email }}',
          pass: '{{ \Auth::user()->email }}',
          email: '{{ \Auth::user()->email }}'
      };
  var QBoccupantsId = 0;
  var dialogs_list = [];
  </script>

  <script src="chat/js/quickblox.min.js"></script>
  <script src="chat/libs/stickerpipe/js/stickerpipe.js"></script>
  <script src="chat/js/config.js"></script>
  <script src="chat/js/connection.js"></script>
  <script type="text/javascript">var myId = '{{ \Auth::user()->chat_id }}'; console.log(myId);</script>
  <script src="chat/js/messages.js"></script>
  <script src="chat/js/stickerpipe.js"></script>
  <script src="chat/js/ui_helpers.js"></script>
  <script src="chat/js/dialogs.js"></script>
  <script src="chat/js/users.js"></script>
@endsection