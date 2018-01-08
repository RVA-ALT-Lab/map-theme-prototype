var MapTool = new MapUtilityClass($);

var mymap = MapTool.initMap();

L.polygon(MapTool.latlngs, { color: 'white', fillOpacity: .15 }).addTo(mymap);

var postID = document.querySelector('.post-id').value;

MapTool.getMapPointsById(postID)
.then(data => {
    MapTool.addSingleMapMarker(data, mymap)
    mymap.flyTo([data.meta.latitude, data.meta.longitude])
})