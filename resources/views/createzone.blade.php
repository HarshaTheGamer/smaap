@extends('layouts.app')
@section('style')
#map-canvas { width:100%; height: 450px;}
@endsection
@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAc85iLuEUgPMmrbuW9NPaeAljDF-vJk1M&libraries=places" type="text/javascript"></script>
<script type="text/javascript">
   var locations = [
    @foreach($zones as $zone)
            ['{{ $zone->zone_name }}', {{ $zone->latitude }},{{ $zone->longitude }},{{ $zone->range }} ],
    @endforeach
    ];
    var icon = {
        url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png", // url
        scaledSize: new google.maps.Size(40, 40), // scaled size

    };

    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center:{lat: 37.09024, lng: -95.712891},
        zoom:5

    });
    var marker = new google.maps.Marker({
        position: {lat: 37.09024, lng: -95.712891},
        map: map,
        // icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
        icon: icon,
        draggable: true
    });
    var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));
    var circle = new google.maps.Circle({
      map: map,
      radius: 160930,    // 10 miles in metres
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
            <div class="panel panel-default">
                <div class="panel-heading">CREATE NEW ZONE</div>

                <div class="panel-body">

                     @include('errors.common')               

                    <!-- New Task Form -->
                    <form action="{{ url('zone/create') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="zone" class="col-sm-3 control-label">Zone Name</label>

                            <div class="col-sm-6">
                                <input type="text" name="zonename" id="zone-name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lat" class="col-sm-3 control-label">Latitude</label>

                            <div class="col-sm-6">
                                <input type="text" name="lat" onchange="myFunction()" id="latitude" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="zone" class="col-sm-3 control-label">Longitude</label>

                            <div class="col-sm-6">
                                <input type="text" name="lng" onchange="myFunction()" id="longitude" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="range" class="col-sm-3 control-label">Radius (miles)</label>

                            <div class="col-sm-6">
                                <input type="number" name="range" onchange="myFunction(this.value)" id="radius"  max="10" min="0" name="range" step="any" class="form-control" required>
                            </div>
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="pull-right btn btn-default">
                                    <i class="fa fa-plus"></i> Add Zone
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

@endsection
