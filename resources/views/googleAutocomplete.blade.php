<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Google Maps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style type="text/css">
        #map {
            height: 600px;
        }

        /* Custom styles for the search box */
        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon {
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
        }

        #search {
            width: 300px;
            padding: 10px;
            padding-left: 30px;
            /* Add padding for the search icon */
            border: none;
            border-radius: 100px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            outline: none;
            font-size: 15px;
        }

        #suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 6px 6px;
            z-index: 1000;
        }

        .suggestion {
            padding: 10px;
            cursor: pointer;
        }

        .suggestion:hover {
            background-color: #f5f5f5;
        }

    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Google Maps</h1>
        <div class="search-container">
            <span class="search-icon">&#128269;</span>
            <input type="text" id="search" placeholder="Search for a location">
            <div id="suggestions"></div>
        </div>
        <div id="map"></div>
    </div>
    <div>
        <input type="submit" id="submit" name="submit" value="Submit">
    </div>


    <script type="text/javascript">
        var map;
        var marker;
        var autocomplete;
        var drawingManager;
        let drawnShapes = [];
        var selectedShape;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 6
                , center: {
                    lat: 0
                    , lng: 0
                }
            });

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLatLng = {
                        lat: position.coords.latitude
                        , lng: position.coords.longitude
                    };

                    map.setCenter(userLatLng);
                    marker = new google.maps.Marker({
                        position: userLatLng
                        , map: map
                        , title: "Your Location"
                    });
                });
            } else {
                alert("Geolocation is not available or denied by the user.");
            }

            // Initialize the drawing manager
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingControl: true
                , drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER
                    , drawingModes: [
                        google.maps.drawing.OverlayType.MARKER
                        , google.maps.drawing.OverlayType.CIRCLE
                        , google.maps.drawing.OverlayType.POLYGON
                        , google.maps.drawing.OverlayType.POLYLINE
                        , google.maps.drawing.OverlayType.RECTANGLE
                    , ]
                , }
                , markerOptions: {
                    icon: "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png"
                , }
                , circleOptions: {
                    fillColor: "#ffff00"
                    , fillOpacity: 1
                    , strokeWeight: 5
                    , clickable: false
                    , editable: true
                    , zIndex: 1
                , }
            , });

            drawingManager.setMap(map);

            // Initialize the autocomplete object
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('search')
            );
            autocomplete.setTypes([]);


            autocomplete.addListener('place_changed', onPlaceChanged);

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                const shape = event.overlay;
                const type = event.type;
                const coordinates = captureCoordinates(shape, type);

                // Store the captured shape and its coordinates
                drawnShapes.push({
                    type
                    , coordinates
                });
            });

            var submitButton = document.getElementById("submit");
            submitButton.addEventListener("click", saveLocation);
        }

        function onPlaceChanged() {
            var place = autocomplete.getPlace();

            if (!place.geometry) {
                return;
            }

            // Update the map and marker with the selected place
            var location = place.geometry.location;
            map.setCenter(location);

            if (marker) {
                marker.setPosition(location);
            } else {
                marker = new google.maps.Marker({
                    position: location
                    , map: map
                    , title: place.name
                });
            }
        }
        // Inside your existing JavaScript code

        function captureCoordinates(shape, type) {
            let coordinates = [];

            if (type === google.maps.drawing.OverlayType.MARKER) {
                const position = shape.getPosition();
                coordinates.push({
                    lat: position.lat()
                    , lng: position.lng()
                });
            } else if (type === google.maps.drawing.OverlayType.CIRCLE) {
                const center = shape.getCenter();
                const radius = shape.getRadius();
                coordinates.push({
                    center: {
                        lat: center.lat()
                        , lng: center.lng()
                    }
                    , radius
                });
            } else if (type === google.maps.drawing.OverlayType.POLYGON || type === google.maps.drawing.OverlayType.POLYLINE) {
                const path = shape.getPath().getArray();
                coordinates = path.map(point => ({
                    lat: point.lat()
                    , lng: point.lng()
                }));
            } else if (type === google.maps.drawing.OverlayType.RECTANGLE) {
                const bounds = shape.getBounds();
                const northEast = bounds.getNorthEast();
                const southWest = bounds.getSouthWest();
                coordinates.push({
                    bounds: {
                        northEast: {
                            lat: northEast.lat()
                            , lng: northEast.lng()
                        }
                        , southWest: {
                            lat: southWest.lat()
                            , lng: southWest.lng()
                        }
                    }
                });
            }

            return coordinates;
        }

        function saveLocation() {
            console.log(drawnShapes);

            // Send the captured shapes and coordinates to the server (PHP)
            fetch('{{ route('save.location')}}', {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                        , body: JSON.stringify(drawnShapes)
                    , })
                .then(response => {
                    if (response.ok) {
                        // Data was successfully saved in the database
                        console.log('Locations saved successfully.');
                    } else {
                        // Handle errors here
                        console.error('Error saving locations.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        // ... (Rest of your code)

    </script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBg_Sps4Shh-oGpfwczSIjfC65Ge6LutSM&callback=initMap&libraries=places,drawing"></script>

</body>

</html>
