@extends('backend::layouts._backend')

@section('content')


<div id="map" class="_fwfl _r2 google-map"></div>
<div id="save-widget" class="save-widget">
    <strong>We're King</strong>
    <p>We’re located on the water in Pyrmont, with views of the Sydney Harbour Bridge, The
        Rocks and Darling Harbour.
    </p>
</div>



<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>

    function initMap() {
        var longLat = {lat: 10.814653800634558, lng: 106.66705602416187},
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 17,
            center: longLat,
            mapTypeControlOptions: {
                mapTypeIds: [
                    google.maps.MapTypeId.ROADMAP,
                    google.maps.MapTypeId.SATELLITE
                ],
                position: google.maps.ControlPosition.BOTTOM_LEFT
            }
        });

        var widgetDiv = document.getElementById('save-widget');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(widgetDiv);

        var saveWidget = new google.maps.SaveWidget(widgetDiv, {
            place: {
                placeId: 'ChIJN1t_tDeuEmsRUsoyG83frY4',
                location: longLat
            },
            attribution: {
                source: 'Google Maps JavaScript API',
                webUrl: 'https://developers.google.com/maps/'
            }
        });

        var marker = new google.maps.Marker({
            map: map,
            position: saveWidget.getPlace().location,
            visible: true
        });

        google.maps.event.addListener(map, 'click', function(event) {
            //alert("Latitude: " + event.latLng.lat() + " " + ", longitude: " + event.latLng.lng());
            placeMarker(event.latLng);
        });

        function placeMarker(location) {

            if (marker === undefined) {
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    animation: google.maps.Animation.DROP,
                });
            } else {
                marker.setPosition(location);
            }

            map.setCenter(location);

        }
    }

    initMap();

</script>

@stop