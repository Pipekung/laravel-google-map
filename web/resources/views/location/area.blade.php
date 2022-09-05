<style>
    body {
        margin: 0;
        padding: 0;
    }
    #map {
        display: inline-block;
        height: 100vh;
        width: 80vw;
    }
    .aside {
        display: inline-block;
        height: 100vh;
        width: 19vw;
        vertical-align: text-bottom;
    }
</style>
<div class="aside">
    <ul>
        @foreach($areas as $area)
            <li><a href="?name={{ $area->title }}">{{ $area->title }}</a></li>
        @endforeach
    </ul>
</div>
<div id="map"></div>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&libraries=geometry"></script>
<script>
function initialize() {
    @if($name)
    fetch('http://127.0.0.1:50000/api/location/area?name={{ $name }}', {
        method: "GET",
    })
    .then(response => response.json())
    .then(locations => {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: { lat: parseFloat(locations[0].lat), lng: parseFloat(locations[0].lng) },
        });
        var coordinates = []
        locations.forEach(location => {
            coordinates.push({lat: parseFloat(location.lat), lng: parseFloat(location.lng) })
        });
        const polygon = new google.maps.Polygon({
            path: coordinates,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
        });

        polygon.setMap(map);
        area = google.maps.geometry.spherical.computeArea(polygon.getPath());
        length = google.maps.geometry.spherical.computeLength(polygon.getPath());
        var infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(polygon, 'click', function(event) {
            if (area > 10000) {
                var contentString = `
                    <p>Name: ${locations[0].title}</p>
                    <p>Area: ${(area / 10000).toFixed(2)} km<sup>2</sup></p>
                    <p>Length: ${(length / 1000).toFixed(2)} km.</p>
                `;
            } else {
                var contentString = `
                    <p>Name: ${locations[0].title}</p>
                    <p>Area: ${(area / 10).toFixed(2)} m<sup>2</sup></p>
                    <p>Length: ${length.toFixed(2)} m.</p>
                `;
            }
            infowindow.setContent(contentString);
            infowindow.setPosition(event.latLng);
            infowindow.open(map);
        });
    })
    .catch(err => {
        console.error('ERROR: ', err);
        new google.maps.Map(document.getElementById("map"), {
            zoom: 2.5,
            center: { lat: 0, lng: 0 },
        });
    })
    @else
    new google.maps.Map(document.getElementById("map"), {
        zoom: 2.5,
        center: { lat: 0, lng: 0 },
    });
    @endif
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
