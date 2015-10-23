@extends('backend::layouts._backend')

@section('content')
backend_map_save
<h3 class="_tg6 _fs20">{{ _t('backend_map') }}</h3>
<hr />
<div class="_fwfl">
    <div id="map" class="_fwfl _r2 google-map"></div>
    <div id="save-widget" class="save-widget">
        {!! $map_data['map_widget'] !!}
    </div>
</div>

<form class="_fwfl _mt20" method="POST" action="{{ route('backend_map_save') }}">
    {{ csrf_field() }}
    <div class="_fwfl">
        <input type="text" class="form-control map-field _r2" id="longitude" name="map_long" value="{{ $map_data['map_long'] }}"/>
        <input type="text" class="form-control map-field _r2" id="latitude" name="map_lat" value="{{ $map_data['map_lat'] }}"/>
        <button type="submit" class="btn btn-primary _r2">{{ _t('backend_map_save') }}</button>
    </div>

    <div class="_fwfl">
        <h3 class="_tg6 _fs15">{{ _t('backend_map_desc') }}</h3>
        <textarea id="_tinymce" name="map_widget">{!! $map_data['map_widget'] !!}</textarea>
    </div>
</form>


<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>

    function initMap() {
        var longLat = {lat: <?php echo $map_data['map_lat'] ?>, lng: <?php echo $map_data['map_long'] ?>},
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

        <?php if($map_data['map_widget'] !== '') : ?>
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
        <?php endif; ?>

        var marker = new google.maps.Marker({
            map: map,
            position: longLat,
            visible: true
        });

        google.maps.event.addListener(map, 'click', function(event) {

            $('#longitude').val(event.latLng.lng());
            $('#latitude').val(event.latLng.lat());

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