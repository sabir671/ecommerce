<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Other meta tags and styles -->
    <title>Google Maps</title>
    <!-- Include Google Maps API script -->
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBg_Sps4Shh-oGpfwczSIjfC65Ge6LutSM&callback=initMap" async defer></script>
    <!-- Other styles and scripts -->
</head>
<body>
    <div>
        <input id="locationInput" type="text" placeholder="Enter a location">
        <button onclick="searchLocation()">Search</button>
    </div>
    <div id="map" style="height: 400px;"></div>

    <script>
        var map;
        var polygon;
        var infoWindow;
        var marker;

        function initMap() {
            // Create a new Google Maps instance
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 36.94557493701555, lng: 75.09793177102762 },
                zoom: 10
            });

            // Define your polygon coordinates
            var polygonCoordinates = [
                { lat: 36.94557493701555, lng: 75.09793177102762 },
                { lat: 35.25915133304944, lng: 76.04275598977762 },
                { lat: 34.6287633415003, lng: 72.39529505227762 },
                { lat: 36.416935822183, lng: 71.58230677102762 }
            ];

            // Create a polygon and set its path
            polygon = new google.maps.Polygon({
                paths: polygonCoordinates,
                map: map
            });

            // Create an info window for displaying results
            infoWindow = new google.maps.InfoWindow();

            // Fit the map to the bounds of the polygon
            var bounds = new google.maps.LatLngBounds();
            polygonCoordinates.forEach(function(coord) {
                bounds.extend(coord);
            });
            map.fitBounds(bounds);
        }

        function searchLocation() {
    var locationInput = document.getElementById('locationInput').value;

    // Use the Google Maps Geocoder to get the coordinates and formatted address of the entered location
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ address: locationInput }, function(results, status) {
        if (status === 'OK') {
            var location = results[0].geometry.location;
            var formattedAddress = results[0].formatted_address;

            // Check if the location is inside the polygon
            var isInside = google.maps.geometry.poly.containsLocation(location, polygon);

            if (isInside) {
                // Create a marker with the default red pin
                if (marker) {
                    marker.setMap(null); // Remove previous marker
                }

                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: formattedAddress // Use the formatted address as the marker title
                });

                // Set the map's center to the searched location
                map.setCenter(location);

                // Add a click event listener to the marker to open a new tab with details
                marker.addListener('click', function() {
                    window.open('https://www.google.com/maps/place/' + encodeURIComponent(formattedAddress));
                });
            } else {
                alert('Location is outside the polygon.');
            }
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}



    </script>
</body>
</html>
