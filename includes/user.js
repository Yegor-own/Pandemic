navigator.geolocation.getCurrentPosition(
    function(position) {
        let lat = position.coords.latitude
        let lng = position.coords.longitude
        
        const map = L.map('rout', {}).setView([lat, lng], 13)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map)
        let location1
        let location2
        let polyline
        let marker
        function sendPost() {
            if (location2 != null && location2 != undefined) {
                if (polyline) {
                    map.removeLayer(polyline)
                }
                map.removeLayer(marker)
                polyline = L.Routing.control({
                    waypoints: [
                        L.latLng(location1),
                        L.latLng(location2)
                    ],
                    routeWhileDragging: false,
                }).addTo(map)
            }
        }
        map.on('click', function(e) {
            if (location1 === undefined) {
                location1 = e.latlng
                marker = new L.Marker(e.latlng).addTo(map)
            }
            else if (location2 === undefined) {
                location2 = e.latlng
                sendPost()
            }
        })
    }
)