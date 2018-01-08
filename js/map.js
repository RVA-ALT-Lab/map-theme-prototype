var MapTool = new MapUtilityClass(jQuery);

var mymap = MapTool.initMap();

L.polygon(MapTool.latlngs, { color: 'white', fillOpacity: .15 }).addTo(mymap);


MapTool.getMapPoints()
.then(data => {
    MapTool.addMapMarkers(data, mymap)
})