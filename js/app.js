var MapUtilityClass = function ($) {
    var self = this;
    this.currentUser = WPOPTIONS.currentuser;
    this.themeOptions = WPOPTIONS.theme_options;
    this.siteURL = WPURLS.siteurl.replace('http', 'https');
    this.currentPoints;
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

    this.mapMarkers = []

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
    this.getMapPointColor = function (category){
        if (category) {
            dataCategory = `[data-category='${category}']`
            let domElement = document.querySelector(dataCategory).getAttribute('data-color')
            return domElement
        } else {
            return '#FF5733'
        }
    }
    this.getMapPoints = function ( ) {

        if (self.themeOptions.hidden_work == '1'){

            if (self.currentUser.roles.includes("administrator")){
                //Here the admin gets all of the posts
                var url = '/wp-json/wp/v2/map-point?_embed&per_page=100';
            } else if (self.currentUser.ID !== 0) {
                //If there is a current user, we get their posts
                var url = '/wp-json/wp/v2/map-point?_embed&per_page=100&author=' + self.currentUser.ID
            } else {
                //If not a current user, we get all posts
                var url = '/wp-json/wp/v2/map-point?_embed&per_page=100'
            }
        } else {
            var url = '/wp-json/wp/v2/map-point?_embed&per_page=100';
        }

        return new Promise( (resolve, reject) => {
            $.get( self.siteURL + url)
            .done(data => resolve(data))
            .fail(error => reject(error))
        })
    }

    this.getMapPointsByCategory = function ( categoryID ) {

        if (self.themeOptions.hidden_work == '1'){
            if (self.currentUser.roles.includes("administrator")){
                //Here the admin gets all of the posts
                var url = '/wp-json/wp/v2/map-point?_embed&per_page=100&map-point-category=' + categoryID;
            } else if (self.currentUser.ID !== 0) {
                //If there is a current user, we get their posts
                var url = '/wp-json/wp/v2/map-point?_embed&per_page=100&author=' + self.currentUser.ID + '&map-point-category=' + categoryID;
            } else {
                //If not a current user, we get all posts
                var url = '/wp-json/wp/v2/map-point?_embed&per_page=100&map-point-category=' + categoryID;
            }
        } else {
            var url = '/wp-json/wp/v2/map-point?_embed&per_page=100&map-point-category=' + categoryID;
        }


        return new Promise( (resolve, reject) => {
            $.get(self.siteURL + url)
            .done(data => resolve(data))
            .fail(error => reject(error))
        })
    }

    this.getMapPointsById = function ( postID ) {
        return new Promise( (resolve, reject) => {
            $.get( self.siteURL + '/wp-json/wp/v2/map-point/'+ postID + '?_embed')
            .done(data => resolve(data))
            .fail(error => reject(error))
        })
    }

    // This method takes an array of JSON from the REST API
    this.addMapMarkers = function (data, map) {

        data.forEach(point => {

            let featuredImage =
                point._embedded['wp:featuredmedia'] ?
                point._embedded['wp:featuredmedia'][0].source_url :
                false

            let mapPointCategory =
                point['map-point-category'][0]
                ? point['map-point-category'][0]
                : null

            var markerHtmlStyles = `
            background-color: ${this.getMapPointColor(mapPointCategory)};
            width: 2rem;
            height: 2rem;
            display: block;
            left: -1rem;
            top: -1rem;
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

            if (featuredImage) {
                var markerContent = `
                <h4>${point.title.rendered}</h4>
                <img src='${featuredImage}' height='200' width='200'>
                <br>
                <a class='btn btn-primary btn-block' href='${point.link}'>Read More</a>
                `
            } else {
                var markerContent = `
                <h4>${point.title.rendered}</h4>
                <br>
                <a class='btn btn-primary btn-block' href='${point.link}'>Read More</a>
                `
            }
            marker.bindPopup(markerContent)
            self.mapMarkers.push(marker)
        })
    }

    this.addSingleMapMarker = function (data, map) {
                let featuredImage =
                data._embedded['wp:featuredmedia'] ?
                data._embedded['wp:featuredmedia'][0].source_url :
                false

                // todo: add in check for catgegory to determine color
                var markerHtmlStyles = `
                background-color: ${this.getMapPointColor(data['map-point-category'][0])};
                width: 2rem;
                height: 2rem;
                display: block;
                left: -1rem;
                top: -1rem;
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

                if (featuredImage) {
                    var markerContent = `
                    <h4>${data.title.rendered}</h4>
                    <img src='${featuredImage}' height='200' width='200'>
                    <br>
                    <a class='btn btn-primary btn-block' href='${data.link}'>Read More</a>
                    `
                } else {
                    var markerContent = `
                    <h4>${data.title.rendered}</h4>
                    <br>
                    <a class='btn btn-primary btn-block' href='${data.link}'>Read More</a>
                    `
                }

                marker.bindPopup(markerContent)
                self.mapMarkers.push(marker)
            }
    this.createHeatMapLayer =  function (data, map){
        let heatmapCoords = data.map( point => {
            return {"lat" :point.meta.latitude, "lng": point.meta.longitude}
        })
        L.heatLayer(heatmapCoords).addTo(map)
        self.removeMapMarkers(map)

    }
    this.removeMapMarkers = function (map) {
        self.mapMarkers.forEach(marker => {
            console.log(marker)
            map.removeLayer(marker)
        })
    }

}