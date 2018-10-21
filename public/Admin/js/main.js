$(document).ready(function () {
    $('.dataTable thead tr').clone(true).appendTo('.dataTable thead');
    $('.dataTable thead tr:eq(1) th').each(function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" />');
        $('input', this).on('keyup change', function () {
            if (table.column(i).search() !== this.value) {
                table.column(i).search(this.value).draw();
            }
        });
    });

    var table = $('.dataTable').DataTable();
});

jQuery(window).on('load', function () {
    var $googleMaps = jQuery('.clickable-map');
    if ($googleMaps.length) {
        $googleMaps.each(function () {
            var $map = jQuery(this);

            //map styles. You can grab different styles on https://snazzymaps.com/
            var styles = [{
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [{"visibility": "on"}, {"color": "#e0efef"}]
            }, {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [{"visibility": "on"}, {"hue": "#1900ff"}, {"color": "#c0e8e8"}]
            }, {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [{"lightness": 100}, {"visibility": "simplified"}]
            }, {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [{"visibility": "off"}]
            }, {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [{"visibility": "on"}, {"lightness": 700}]
            }, {"featureType": "water", "elementType": "all", "stylers": [{"color": "#7dcdcd"}]}];

            var markerIconSrc = $map.find('.map_marker_icon').first().attr('src');

            var lat = $map.data('lat') ? $map.data('lat') : 0;
            var lng = $map.data('lng') ? $map.data('lng') : 0;
            var zoom = 2;

            var latitudeInput = $($map.data('latitude-input'));
            var longitudeInput = $($map.data('longitude-input'));

            if (lat == 0 || lng == 0) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        lat = position.coords.latitude;
                        lng = position.coords.longitude;
                        zoom = 16;
                        drawMap($map[0], lat, lng, zoom, markerIconSrc, styles, latitudeInput, longitudeInput);
                    }, function () {
                        drawMap($map[0], lat, lng, zoom, markerIconSrc, styles, latitudeInput, longitudeInput);
                    });
                } else {
                    drawMap($map[0], lat, lng, zoom, markerIconSrc, styles, latitudeInput, longitudeInput);
                }
            } else {
                zoom = 16;
                drawMap($map[0], lat, lng, zoom, markerIconSrc, styles, latitudeInput, longitudeInput);
            }

        }); //each
    }//google map length

    function drawMap(elm, lat, lng, zoom, markerIconSrc, styles, latitudeInput, longitudeInput) {
        var center = new google.maps.LatLng(lat, lng);
        var settings = {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: zoom,
            draggable: true,
            scrollwheel: false,
            center: center,
            styles: styles
        };
        var map = new google.maps.Map(elm, settings);

        var marker = new google.maps.Marker({
            position: center,
            map: map,
            icon: markerIconSrc,
        });

        map.addListener('click', function (e) {
            map.panTo(e.latLng);
            marker.setPosition(e.latLng);
            latitudeInput.val(e.latLng.lat());
            longitudeInput.val(e.latLng.lng());
        });

        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();
            if (places.length == 0)
                return;

            places.forEach(function (place) {
                if (!place.geometry)
                    return;

                map.panTo(place.geometry.location);
                marker.setPosition(place.geometry.location);
                latitudeInput.val(place.geometry.location.lat());
                longitudeInput.val(place.geometry.location.lng());
            });
        });

        map.addListener('tilesloaded', function () {
            input.style.display = "block";
        })
    }
}); //end of "window load" event

jQuery(window).on('load', function () {
    var $googleMaps = jQuery('.map');
    if ($googleMaps.length) {
        $googleMaps.each(function () {
            var $map = jQuery(this);

            //map styles. You can grab different styles on https://snazzymaps.com/
            var styles = [{
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [{"visibility": "on"}, {"color": "#e0efef"}]
            }, {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [{"visibility": "on"}, {"hue": "#1900ff"}, {"color": "#c0e8e8"}]
            }, {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [{"lightness": 100}, {"visibility": "simplified"}]
            }, {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [{"visibility": "off"}]
            }, {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [{"visibility": "on"}, {"lightness": 700}]
            }, {"featureType": "water", "elementType": "all", "stylers": [{"color": "#7dcdcd"}]}];

            //map settings
            var address = $map.data('address') ? $map.data('address') : '';
            var markerDescription = $map.find('.map_marker_description').prop('outerHTML');

            //if you do not provide map title inside #map (.page_map) section inside H3 tag - default titile (Map Title) goes here:
            var markerTitle = $map.find('h3').first().text() ? $map.find('h3').first().text() : 'Map Title';
            var markerIconSrc = $map.find('.map_marker_icon').first().attr('src');

            var lat = $map.data('lat') ? $map.data('lat') : 0;
            var lng = $map.data('lng') ? $map.data('lng') : 0;

            drawMap($map[0], lat, lng, markerTitle, markerIconSrc, markerDescription, styles);
        }); //each
    }//google map length

    function drawMap(elm, lat, lng, markerTitle, markerIconSrc, markerDescription, styles) {
        var center = new google.maps.LatLng(lat, lng);
        var settings = {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 13,
            draggable: true,
            scrollwheel: false,
            center: center,
            styles: styles
        };
        var map = new google.maps.Map(elm, settings);

        var marker = new google.maps.Marker({
            position: center,
            title: markerTitle,
            map: map,
            icon: markerIconSrc,
        });

        var infowindow = new google.maps.InfoWindow({
            content: markerDescription
        });

        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });
    }

}); //end of "window load" event


$(document).ready(function () {
    tinymce.init({selector: 'textarea.tinymce'});
    if ($("select.multiselect").length) {
        $('select.multiselect').multiselect();
    }
});
