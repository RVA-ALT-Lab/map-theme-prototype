var MapTool = new MapUtilityClass();
var mymap = MapTool.initMap();
var isGeolocating = true;

L.polygon(MapTool.latlngs, { color: 'white', fillOpacity: .15 }).addTo(mymap);

MapTool.startGeolocation(mymap)

var userPositionCircle = L.circle(
    MapTool.richmondCentroid
    ).addTo(mymap);

function onLocationFound (e) {
    if (!isGeolocating && e.type === 'click'){
        latInput.value = e.latlng.lat
        longInput.value = e.latlng.lng
        userPositionCircle.setLatLng([e.latlng.lat, e.latlng.lng]);
    } else if (e.type === 'locationfound') {
        latInput.value = e.latitude
        longInput.value = e.longitude
        userPositionCircle.setLatLng([e.latitude, e.longitude]);
    }
}

mymap.on('locationfound', onLocationFound);


var latInput = document.getElementById('latitude');
var longInput = document.getElementById('longitude');

latInput.value = MapTool.richmondCentroid[0]
longInput.value = MapTool.richmondCentroid[1]


var stopGeolocationButton = document.querySelector('.stop-geolocation');
var startGeolocationButton = document.querySelector('.start-geolocation');



stopGeolocationButton.addEventListener('click', function () {
    isGeolocating = false;
    userPositionCircle.setLatLng(['', ''])
    MapTool.stopGeolocation(mymap)
    startGeolocationButton.style.display = 'block';
    stopGeolocationButton.style.display = 'none';
})

startGeolocationButton.addEventListener('click', function () {
    isGeolocating = true;
    MapTool.startGeolocation(mymap)
    startGeolocationButton.style.display = 'none';
    stopGeolocationButton.style.display = 'block';
})

mymap.on('click', onLocationFound)