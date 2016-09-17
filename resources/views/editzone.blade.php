@extends('layouts.app')
@section('style')
#map-canvas { width:100%; height: 450px;}
@endsection
@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAc85iLuEUgPMmrbuW9NPaeAljDF-vJk1M&libraries=places" type="text/javascript"></script>
<script type="text/javascript">
   var locations = [
    @foreach($zones as $zone)
        @if($zone->id != $editzone->id)
            ['{{ $zone->zone_name }}', {{ $zone->latitude }},{{ $zone->longitude }},{{ $zone->range }} ],
        @endif
    @endforeach
    ];
    var editlng ={{ $editzone->longitude }};
    var editlat ={{ $editzone->latitude }};
    var editrad =({{ $editzone->range }}*1609);

    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center:{lat: editlat, lng: editlng},
        zoom:11

    });
    var marker = new google.maps.Marker({
        position: {lat: editlat, lng: editlng},
        map: map,
        icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
        draggable: true
    });
    var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));
    var circle = new google.maps.Circle({
      map: map,
      radius: editrad,    // 10 miles in metres
      fillColor: '#00AA00',
      strokeWeight: '1',
      strokeColor: '#0AAAA0',
      draggable: true,
      editable: true
    });
    circle.bindTo('center', marker, 'position');

    google.maps.event.addListener(searchBox,'places_changed',function(){

        var places =searchBox.getPlaces();
        var bounds = new google.maps.LatLngBounds();
        var i, place;

        for(i=0; place=places[i]; i++){
            bounds.extend(place.geometry.location);
            marker.setPosition(place.geometry.location);

        }
        map.fitBounds(bounds);
        map.setZoom(10);

    });

    google.maps.event.addListener(marker,'position_changed',function(){

        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();
        var radius = circle.getRadius()/1609.3;

        $('#latitude').val(lat);
        $('#longitude').val(lng);
        $('#radius').val(radius);

    });

    google.maps.event.addListener(circle,'radius_changed',function(){

        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();
        var radius = circle.getRadius()/1609.3;

        $('#latitude').val(lat);
        $('#longitude').val(lng);
        $('#radius').val(radius);

    });
           var marker, i, circle;
    for (i = 0; i < locations.length; i++) { 
        marker1= new google.maps.Marker({
            position: {lat: locations[i][1], lng: locations[i][2]},
            map: map,
            title: locations[i][0]
        });

        circle1 = new google.maps.Circle({
          map: map,
          radius: locations[i][3]*1609.344,    // 10 miles in metres
          fillColor: '#AA0000',
          strokeWeight: '1',
          strokeColor: '#AAA0A0'
        });
        circle1.bindTo('center', marker1, 'position');
    }


    


</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">EDIT ZONE</div>

                <div class="panel-body">

                     @include('errors.common')               

                    <!-- New Task Form -->
                    <form action="{{ url('zone/update') }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="zone" class="col-sm-3 control-label">Zone Name</label>
                            <input type="hidden" name="id" id="zone-id" class="form-control" value="{{ $editzone->id }}">

                            <div class="col-sm-6">
                                <input type="text" name="zonename" id="zone-name" class="form-control" value="{{ $editzone->zone_name }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lat" class="col-sm-3 control-label">Latitude</label>

                            <div class="col-sm-6">
                                <input type="text" name="lat" value="{{ $editzone->latitude }}" onchange="myFunction()" id="latitude" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="zone" class="col-sm-3 control-label">Longitude</label>

                            <div class="col-sm-6">
                                <input type="text" name="lng" value="{{ $editzone->longitude }}" onchange="myFunction()" id="longitude" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="range" class="col-sm-3 control-label">Radius (miles)</label>

                            <div class="col-sm-6">
                                <input type="number" name="range" value="{{ $editzone->range }}" onchange="myFunction(this.value)" id="radius"  max="10" min="0" name="range" step="any" class="form-control" required>
                            </div>
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="pull-right btn btn-default">
                                    <i class="fa fa-plus"></i> Update Zone
                                </button>
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="">Search location here</label>
                        <input type="text" id="searchmap" placeholder="Search in map">
                        <div id="map-canvas"></div>                        
                    </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
