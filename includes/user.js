navigator.geolocation.getCurrentPosition(
    function(position) {
        let lat = position.coords.latitude
        let lng = position.coords.longitude
        
        const map = L.map('rout', {}).setView([lat, lng], 13)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map)
        let location1
        let location2
        let polyline
        function sendPost() {
            if (location2 != null && location1 != null) {
                // let p1 = location1.getLatLng(),
                //     p2 = location2.getLatLng()
                if (polyline) {
                    map.removeLayer(polyline)
                }
                polyline = L.Routing.control({
                    waypoints: [
                        L.latLng(location1),
                        L.latLng(location2)
                    ],
                    routeWhileDragging: true,
                }).addTo(map)
                // L.Routing.control({
                //     waypoints: [
                //         L.latLng(57.74, 11.94),
                //         L.latLng(57.6792, 11.949)
                //     ],
                //     routeWhileDragging: true
                // }).addTo(map);
            }
        }
        map.on('click', function(e) {
            if (location1 === undefined) {
                location1 = e.latlng;
            }
            else if (location2 === undefined) {
                location2 = e.latlng;
                sendPost()
            }
        })
    }
)