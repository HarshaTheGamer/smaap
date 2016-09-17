//"use strict";

var currentUser;

$(document).ready(function() {

    currentUser = QBUser1;
    $('#loadingo').show();
    connectToChat(QBUser1);

});
// $(document).ready(function() {

  
//   var counter = 0; //should be out of your function scope

//     setTimeout(function(){
//          counter +=1;
//          if (counter == 1){
//          //yourFunction()
//          createNewDialog();
//       }
//     },10000)

   
// });

function connectToChat(user) {

  // Create session and connect to chat
  //
  QB.createSession({email: user.email, password: user.pass}, function(err, res) {
    if (res) {
      // save session token
      token = res.token;

      user.id = res.user_id;
      mergeUsers([{user: user}]);

      QB.chat.connect({userId: user.id, password: user.pass}, function(err, roster) {
        if (err) {
          console.log(err);
          alert("not connecting to chat");
        } else {

          console.log(roster);
          // setup scroll stickerpipe module
          //
          setupStickerPipe();

          // load chat dialogs
          //
          showNewDialog();
          retrieveChatDialogs();


          // setup message listeners
          //
          setupAllListeners();

          // setup scroll events handler
          //
          setupMsgScrollHandler();

         
        }
      });
    }
  });
}

function setupAllListeners() {
  QB.chat.onDisconnectedListener    = onDisconnectedListener;
  QB.chat.onReconnectListener       = onReconnectListener;
  QB.chat.onMessageListener         = onMessage;
  QB.chat.onSystemMessageListener   = onSystemMessageListener;
  QB.chat.onDeliveredStatusListener = onDeliveredStatusListener;
  QB.chat.onReadStatusListener      = onReadStatusListener;
  setupIsTypingHandler();
}

// reconnection listeners
function onDisconnectedListener(){
  console.log("onDisconnectedListener");
}

function onReconnectListener(){
  console.log("onReconnectListener");
}


// niceScroll() - ON
$(document).ready(
    function() {
        $("html").niceScroll({cursorcolor:"#02B923", cursorwidth:"7", zindex:"99999"});
        $(".nice-scroll").niceScroll({cursorcolor:"#02B923", cursorwidth:"7", zindex:"99999"});
    }
);
