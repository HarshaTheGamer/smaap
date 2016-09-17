
@extends('layouts.app')
@section('style')
.Profile { width: 50px;
float: left;
height: 100%;
margin: 0px !important; }
#likecount { float:right;}

@endsection

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">PROFILE <span id="likecount">{{ \App\Like::where('user_two', \Auth::user()->id)->count() }} &nbsp&nbsp<span class="glyphicon glyphicon-thumbs-up"></span></span></div>
                    <div class="panel-body">
                    <image src='{{ \Auth::user()->profile }}' width="100%" height="300px">

                    <form enctype="multipart/form-data" action="uploadimage" method="POST" style="margin:10px 0px;">
                        <label> Update Profile Image</label>
                        <input type="file" name="avatar" id="uploader" class="fa fa-cloud-upload">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" value="Upload Image" class="btn btn-sm btn-primary uploadimage">
                    </form>
                    <form action="updatestatus" method="POST">
                        <label> Status</label>
                        <input type="text" name="userstatus" value="{{ \Auth::user()->userstatus }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" value="update status" class="btn btn-sm btn-primary">
                    </form>


                    
                </div>
            </div>            
@endsection

@section('scripts')
<script type="text/javascript">

$('#yourzone').removeClass("active");
$('.uploadimage').hide();
$(':file').change(function(){
    $('.uploadimage').hide();
    var file = this.files[0];
    name = file.name;
    size = file.size;
    type = file.type;

    if(file.name.length < 1) {
    }
    else if(file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/gif' && file.type != 'image/jpeg' ) {
        alert("Please upload image of format png, jpg or gif");
    }
    else { 
        $('.uploadimage').show();
        $(':submit').click(function(){
            var formData = new FormData($('*formId*')[0]);
            $.ajax({
                url: 'script',  //server script to process data
                type: 'POST',
                xhr: function() {  // custom xhr
                    myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload){ // if upload property exists
                        myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // progressbar
                    }
                    return myXhr;
                },
                // Ajax events
                success: completeHandler = function(data) {
                    /*
                    * Workaround for Chrome browser // Delete the fake path
                    */
                    if(navigator.userAgent.indexOf('Chrome')) {
                        var catchFile = $(":file").val().replace(/C:\\fakepath\\/i, '');
                    }
                    else {
                        var catchFile = $(":file").val();
                    }
                    var writeFile = $(":file");
                    writeFile.html(writer(catchFile));
                    $("*setIdOfImageInHiddenInput*").val(data.logo_id);
                },
                // Form data
                data: formData,
                // Options to tell jQuery not to process data or worry about the content-type
                cache: false,
                contentType: false,
                processData: false
            }, 'json');
        });
    }
});
</script>
@endsection
