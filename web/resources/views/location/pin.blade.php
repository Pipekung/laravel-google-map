<style>
    body {
        margin: 0;
        padding: 0;
    }
    #map {
        height: 100vh;
    }
</style>
<div id="map"></div>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}"></script>
<script>
function initialize() {
    fetch('http://127.0.0.1:50000/api/location/pin', {
        method: "GET",
    })
    .then(response => response.json())
    .then(locations => {
        map = new google.maps.Map(document.getElementById("map"), {
            // mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: new google.maps.LatLng({ lat: parseFloat(locations[0].lat), lng: parseFloat(locations[0].lng) }),
            zoom: 15
        });
        for (var i=0; i<locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng({ lat: parseFloat(locations[i].lat), lng: parseFloat(locations[i].lng) }),
                map: map,
            })
            var content = locations[i].title
            var infowindow = new google.maps.InfoWindow()
            google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){
                return function() {
                    infowindow.setContent(content);
                    infowindow.open(map,marker);
                };
            })(marker,content,infowindow));
        }
    })
    .catch(err => {
        console.log('err', err);
    })
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
