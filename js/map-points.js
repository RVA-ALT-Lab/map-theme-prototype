var MapTool = new MapUtilityClass($);

var mymap = MapTool.initMap();

L.polygon(MapTool.latlngs, { color: 'white', fillOpacity: .15 }).addTo(mymap);

var mapPoints;
MapTool.getMapPoints()
.then(data => {
    MapTool.addMapMarkers(data, mymap)
    mapPoints = data
    console.log(data)
})

var zoomButtons = document.querySelectorAll('.zoom-button');

var zoomButtonsArray = Array.from(zoomButtons);

zoomButtonsArray.forEach(button => {
    button.addEventListener('click', function(event){
        var clickedPoint = mapPoints.filter(point => point.id == this.getAttribute('data-id'))[0]
        console.log(clickedPoint)
        mymap.flyTo([clickedPoint.meta.latitude, clickedPoint.meta.longitude])
    })
})