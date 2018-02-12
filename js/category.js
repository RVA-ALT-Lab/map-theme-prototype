var MapTool = new MapUtilityClass(jQuery);

var mymap = MapTool.initMap();

L.polygon(MapTool.latlngs, { color: 'white', fillOpacity: .15 }).addTo(mymap);


var categoryID = document.querySelector('.category-id').value;

MapTool.getMapPointsByCategory(categoryID)
.then(data => {
    MapTool.addMapMarkers(data, mymap)
    MapTool.createHeatMapLayer(data, mymap)
})