var MapUtilityClass = function ($) {
    this.richmondGeoJSON = [
        [-77.4734, 37.5972],
        [-77.3858, 37.537],
        [-77.3913, 37.5041],
        [-77.4186, 37.5151],
        [-77.4186, 37.4494],
        [-77.4898, 37.4548],
        [-77.5282, 37.5315],
        [-77.5939, 37.5534]
    ];

    this.richmondCentroid = [
        -77.476009,
        37.531399
    ]

    this.latlngs = this.richmondGeoJSON.map(function (coords) {
        return [coords[1], coords[0]];
    })

    this.currentPosition = {
        lat: '',
        lng: ''
    }

    this.startGeolocation = function (map) {
        map.locate({ watch: true, enableHighAccuracy: true, setView: true, maxZoom: 16 });
    }

    this.stopGeolocation = function (map) {
        map.stopLocate()
    }

    this.initMap = function ( ) {
        var mymap = L.map('map').setView([37.5536111, -77.4605556], 14);
        L.tileLayer('https://api.mapbox.com/styles/v1/jeffeverhart383/cj9sxi40c2g3s2skby2y6h8jh/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiamVmZmV2ZXJoYXJ0MzgzIiwiYSI6IjIwNzVlOTA3ODI2MTY0MjM3OTgxMTJlODgzNjg5MzM4In0.QA1GsfWZccIB8u0FbhJmRg', {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoiamVmZmV2ZXJoYXJ0MzgzIiwiYSI6ImNqOXI2aDg5ejZhYncyd3M0bHd6cWYxc2oifQ.fzcb7maGkQhAxRZTotB4tg'
        }).addTo(mymap);
        return mymap;
    }

    this.getMapPoints = function ( ) {
        return new Promise( (resolve, reject) => {
            $.get('/wp-json/wp/v2/map-point?_embed&per_page=100')
            .done(data => resolve(data))
            .fail(error => reject(error))
        })
    }

    this.getMapPointsByCategory = function ( categoryID ) {
        return new Promise( (resolve, reject) => {
            $.get('/wp-json/wp/v2/map-point?_embed&per_page=100&map-point-category=' + categoryID)
            .done(data => resolve(data))
            .fail(error => reject(error))
        })
    }

    this.getMapPointsById = function ( postID ) {
        return new Promise( (resolve, reject) => {
            $.get('/wp-json/wp/v2/map-point/'+ postID + '?_embed')
            .done(data => resolve(data))
            .fail(error => reject(error))
        })
    }

    // This method takes an array of JSON from the REST API
    this.addMapMarkers = function (data, map) {

        data.forEach(point => {

            // todo: add in check for catgegory to determine color

            var backgroundColor = point['map-point-category'][0] * 2
            var markerHtmlStyles = `
            background-color: purple;
            width: 3rem;
            height: 3rem;
            display: block;
            left: -1.5rem;
            top: -1.5rem;
            position: relative;
            border-radius: 3rem 3rem 0;
            transform: rotate(45deg);
            border: 1px solid #FFFFFF`

            var icon = L.divIcon({
                className: '',
                iconAnchor: [0, 24],
                labelAnchor: [-6, 0],
                popupAnchor: [0, -36],
                html: `<span style="${markerHtmlStyles}" />`
            })

            var marker = L.marker([point.meta.latitude, point.meta.longitude], {
                icon: icon
            }).addTo(map)
            marker.bindPopup(point.title.rendered)
        })
    }

    this.addSingleMapMarker = function (data, map) {

                    // todo: add in check for catgegory to determine color

                    var backgroundColor = data['map-point-category'][0] * 2
                    var markerHtmlStyles = `
                    background-color: purple);
                    width: 3rem;
                    height: 3rem;
                    display: block;
                    left: -1.5rem;
                    top: -1.5rem;
                    position: relative;
                    border-radius: 3rem 3rem 0;
                    transform: rotate(45deg);
                    border: 1px solid #FFFFFF`

                    var icon = L.divIcon({
                        className: '',
                        iconAnchor: [0, 24],
                        labelAnchor: [-6, 0],
                        popupAnchor: [0, -36],
                        html: `<span style="${markerHtmlStyles}" />`
                    })

                    var marker = L.marker([data.meta.latitude, data.meta.longitude], {
                        icon: icon
                    }).addTo(map)
                    marker.bindPopup(data.title.rendered)
            }

}