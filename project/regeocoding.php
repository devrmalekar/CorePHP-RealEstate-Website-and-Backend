<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
        html, body, #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px;
        }

        .controls {
            margin-top: 16px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
        }

            #pac-input:focus {
                border-color: #4d90fe;
            }

        .pac-container {
            font-family: Roboto;
        }

        #type-selector {
            color: #fff;
            background-color: #4d90fe;
            padding: 5px 11px 0px 11px;
        }

            #type-selector label {
                font-family: Roboto;
                font-size: 13px;
                font-weight: 300;
            }
			#map-canvas{
				width: 650px;
				height:500px;
			}
    </style>
    <title>Places search box</title>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
    <script>
        var getlan = null;
        // This example adds a search box to a map, using the Google Place Autocomplete
        // feature. People can enter geographical searches. The search box will return a
        // pick list containing a mix of places and predicted search terms.
        var marker;
        function initialize() {
            var myLatlng;
            if ((document.getElementById("pac-input").value).length == 0) {
                myLatlng = new google.maps.LatLng(27.672222, 85.427778);
                geocodePosition(myLatlng);
            } else {
               // geocodeAddress(document.getElementById("pac-input").value);
			   var lat =parseFloat(document.getElementById("lat").value);// alert(lat);
			   var lng = parseFloat(document.getElementById("lng").value);
                myLatlng = new google.maps.LatLng(lat, lng); 
				//alert("value = "+myLatlng);
            }
            var image = 'Nepali-flag.gif';

            var mapOptions = {
                zoom: 15,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            var markers = [];
			//alert(image);
            marker = new google.maps.Marker({
                dragable: true,
                position: myLatlng,
                map: map,
                icon: image,
                title: 'Hello World!',
                draggable: true,
                animation: google.maps.Animation.DROP
            });

        
            var defaultBounds = new google.maps.LatLngBounds(
                myLatlng);
            map.fitBounds(defaultBounds);

            // Create the search box and link it to the UI element.
            var input = /** @type {HTMLInputElement} */(
                document.getElementById('pac-input'));
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var searchBox = new google.maps.places.SearchBox(
              /** @type {HTMLInputElement} */(input));

            // [START region_getplaces]
            // Listen for the event fired when the user selects an item from the
            // pick list. Retrieve the matching places for that item.
            google.maps.event.addListener(searchBox, 'places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
              
                marker.setMap(null);
                // For each place, get the icon, place name, and location.
                markers = [];
                var bounds = new google.maps.LatLngBounds();
                for (var i = 0, place; place = places[i]; i++) {
                    var image = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    
                    // Create a marker for each place.
                  
                    marker = new google.maps.Marker({
                        title: place.name,
                        position: place.geometry.location,
                        dragable: true,
                        map: map,
                        icon: 'Nepali-flag.gif',
                        title: 'Nepali-flag.gif',
                        draggable: true,
                        animation: google.maps.Animation.DROP
                    });

                
                    bounds.extend(place.geometry.location);


                }
                google.maps.event.addListener(marker, 'dragend', function (pos) {
                    var currentlatlng = this.getPosition();
					document.getElementById("lat").value = currentlatlng.lat();
					document.getElementById("lng").value = currentlatlng.lng();
                    geocodePosition(currentlatlng);
                });
                map.fitBounds(bounds);
            });
            // [END region_getplaces]

            // Bias the SearchBox results towards places that are within the bounds of the
            // current map's viewport.
            google.maps.event.addListener(map, 'bounds_changed', function () {
                var bounds = map.getBounds();
                searchBox.setBounds(bounds);
            });

            google.maps.event.addListener(marker, 'dragend', function (pos) {
                var currentlatlng = this.getPosition();
				document.getElementById("lat").value = currentlatlng.lat();
					document.getElementById("lng").value = currentlatlng.lng();
                geocodePosition(currentlatlng);
            });
        }

        function geocodePosition(pos) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': pos }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        document.getElementById("pac-input").value = results[1].formatted_address;
                    } else {
                        alert('No results found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
        }

        function geocodeAddress(address) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'address': address }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        document.getElementById("addr").value = results[0].geometry.location;
                        getlan = document.getElementById("addr").value;
                    } else {
                        alert('No results found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    <style>
        #target {
            width: 345px;
        }
    </style>
</head>
<body>
	<input id="lat" type="text" name = "lat" style="display:none" value="<?php echo $glat; ?>" />
    <input id="lng" type="text" name ="lng"  style="display:none" value="<?php echo $glng; ?>" /> 
    <input id="pac-input" name="pacinput" class="controls" type="text" name="gaddress" placeholder="Search Box" value="<?php echo $gaddress; ?>">
    <div id="map-canvas"></div>
</body>
</html>