var MapTool = new MapUtilityClass(jQuery);

var mymap = MapTool.initMap();

L.polygon(MapTool.latlngs, { color: 'white', fillOpacity: .15 }).addTo(mymap);


var categoryID = document.querySelector('.category-id').value;

var mapPoints;
MapTool.getMapPointsByCategory(categoryID)
.then(data => {
    mapPoints = data
    MapTool.addMapMarkers(data, mymap)
})

var zoomButtons = document.querySelectorAll('.zoom-button');

var zoomButtonsArray = Array.from(zoomButtons);

zoomButtonsArray.forEach(button => {
    button.addEventListener('click', function(event){
        var clickedPoint = mapPoints.filter(point => point.id == this.getAttribute('data-id'))[0]
        mymap.flyTo([clickedPoint.meta.latitude, clickedPoint.meta.longitude])
    })
})

var heatMapButton = document.querySelector('#toggleHeatmap')
heatMapButton.addEventListener('click', function(){
    MapTool.createHeatMapLayer(mapPoints, mymap)
})