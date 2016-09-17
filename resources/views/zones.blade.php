@extends('layouts.app')

@section('content')
    <!-- Create zone Form... -->
<!--     @if(Session::has('flash_message'))
            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
    @endif -->
    <!-- Current zones -->
    @if (count($zones) > 0)
    <style type="text/css">
    #searchzone {        
        background-color: #178876;
        border-color: #178876 -moz-use-text-color #178876 #178876;
        color: #FFF;
        margin: 5px 0px 5px 5px;
        width: 90%;
        border-right: 0px none;
        padding: 0px 0px 5px 5px;
    }
    #searchzonebutton {
        background: #DDD none repeat scroll 0% 0%;
        padding: 5px;
        border-left: 0px none;
    }

    #findzone {
        background: transparent none repeat scroll 0% 0%; 
        border: medium none;
    }

    </style>
        <div class="panel panel-default">
            <div class="panel-heading">
                    Current zones   
            </div>

            <div class="panel-body">
                @if(\Auth::user()->email == "admin@smaap.com")
                <div class="col-md-6">
                    <div id="map-canvas"></div>
                </div>
                @else
                    <div id="map-canvas"></div>
                @endif
                 
                    @if(\Auth::user()->email == "admin@smaap.com")
                    <div class="col-md-6">  
                    <div>
                       <input type="text" name = "key" placeholder="search zone by name" id="searchzone"> <i class="fa fa-search" aria-hidden="true" id="searchzonebutton"></i>
                    </div>
                    <div id="zonelist" style="max-height: 410px; overflow: auto;">
                        <table class="table table-striped zone-table">

                        <tbody>
                            <tr>
                                <th class="table-text">Zone Name</th>
                                <th class="table-text">Range</th>
                                <th class="table-text">&nbsp</th>
                                <th class="table-text">&nbsp</th>
                            </tr>

                            @foreach ($zones as $zone)
                                <tr>
                                    <!-- zone Name -->
                                    <td class="table-text">
                                        <div>{{ $zone->zone_name }} 
                                            <button id="findzone" onclick="newLocation({{ $zone->latitude }},{{ $zone->longitude }},'{{ $zone->zone_name }}')">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </td>
                                     <td class="table-text">
                                        <div>{{ $zone->range }}</div>
                                    </td>
                                    <td>
                                        <form action="editzone" method="get">
                  
                                            <input name="id" value="{{ $zone->id }}" type="hidden">

                                            <button type="submit" class="btn btn-info">
                                                <i class="glyphicon glyphicon-edit"></i> Edit
                                            </button>
                                        </form>
                                    </td>
                                     <!-- Delete Button -->
                                    <td>
                                        <form action="{{ url('zones/delete') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input name="id" value="{{ $zone->id }}" type="hidden">
                                             <input name="zonename" value="{{ $zone->zone_name }}" type="hidden">

                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                        
                                    </td>
                                    
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                            @endif
                

                                          
 
            </div>
        </div>
    @endif
@endsection

@section('style')
#map-canvas { width:100%; height: 450px;}
@endsection
@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAc85iLuEUgPMmrbuW9NPaeAljDF-vJk1M&libraries=places" type="text/javascript"></script>
<script type="text/javascript">
var zonelist = document.getElementById("zonelist");

$("#searchzone").keyup(function(){
            $.ajax ({
            url: 'zonelist',
            method: 'get',
            data: { key: $("#searchzone").val()},
            success: function(data){
                zonelist.innerHTML = data;
                      console.log("zonelist list updated successfully."+data);
            },
            error: function(){
                      console.log("fail to get zones");
            },
          });

        });

$('.active').removeClass("active");
$('#nearzones').addClass('active');
  var locations = [
@foreach($zones as $zone)
        ['{{ $zone->zone_name }}', {{ $zone->latitude }},{{ $zone->longitude }},{{ $zone->range }} ],
@endforeach
];

var map;
function initialize()
{
    map = new google.maps.Map(document.getElementById('map-canvas'), {
        center:{lat: 37.09024, lng: -95.712891},
        zoom:4,
        minZoom: 2,
        maxZoom: 15

    });

   var marker, i, circle;
    for (i = 0; i < locations.length; i++) { 
        marker= new google.maps.Marker({
            position: {lat: locations[i][1], lng: locations[i][2]},
            map: map,
            title: locations[i][0]
        });

        circle = new google.maps.Circle({
          map: map,
          radius: locations[i][3]*1609.344,    // 10 miles in metres
          fillColor: '#AA0000',
          strokeWeight: '1',
          strokeColor: '#AAA0A0'
        });
        circle.bindTo('center', marker, 'position');
    }
}

function newLocation(newLat,newLng,zonename)
{
    map = new google.maps.Map(document.getElementById('map-canvas'), {
        center:{lat: newLat, lng: newLng},
        zoom:11,
        minZoom: 2,
        maxZoom: 15

    });
    var marker, i, circle;
    for (i = 0; i < locations.length; i++) {
        if (locations[i][0] != zonename ) {
            marker= new google.maps.Marker({
            position: {lat: locations[i][1], lng: locations[i][2]},
            map: map,
            title: locations[i][0]
            });

            circle = new google.maps.Circle({
              map: map,
              radius: locations[i][3]*1609.344,    // 10 miles in metres
              fillColor: '#AA0000',
              strokeWeight: '1',
              strokeColor: '#AAA0A0'
            });
            circle.bindTo('center', marker, 'position');

        }else {
            marker= new google.maps.Marker({
            position: {lat: locations[i][1], lng: locations[i][2]},
            map: map,
            title: locations[i][0]
            });

            circle = new google.maps.Circle({
              map: map,
              radius: locations[i][3]*1609.344,    // 10 miles in metres
              fillColor: '#0000AA',
              strokeWeight: '1',
              strokeColor: '#A0A0AA'
            });
            circle.bindTo('center', marker, 'position');
        }
        
    }
}

google.maps.event.addDomListener(window, 'load', initialize);

//Setting Location with jQuery
$(document).ready(function ()
{
    $("#1").on('click', function ()
    {
      newLocation(48.1293954,11.556663);
    });
  
    $("#2").on('click', function ()
    {
      newLocation(40.7033127,-73.979681);
    });
  
    $("#3").on('click', function ()
    {
      newLocation(55.749792,37.632495);
    });
});

</script>
@endsection