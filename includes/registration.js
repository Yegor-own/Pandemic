'use srict';
const mapOne = L.map('mapOne', {}).setView([56.8519000, 60.6122000], 13);
const mapTwo = L.map('mapTwo', {}).setView([56.8519000, 60.6122000], 13);
const mapThree = L.map('mapThree', {}).setView([56.8519000, 60.6122000], 13);
const mapboxToken = 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
const mapboxUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const mapboxAttribution = [
    'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors,',
    '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>,',
    'Imagery © <a href="http://mapbox.com">Mapbox</a>',
].join(" ")
const mapbox = (map) => {
    return L.tileLayer(mapboxUrl, {
        id: 'mapbox.streets',
        token: mapboxToken,
        attribution: mapboxAttribution,
    }).addTo(map)
};
[mapOne, mapTwo, mapThree].forEach(mapInstance => mapbox(mapInstance));
// Add a zoom control to the map
const zoomControl = new L.Control.Zoom({
    position: 'topleft'
});
zoomControl.addTo(mapOne);
zoomControl.addTo(mapTwo);
zoomControl.addTo(mapThree);
const scaleControl = L.control.scale({
    maxWidth: 200,
    metric: true,
    imperial: false,
    position: 'bottomright'
});
scaleControl.addTo(mapOne);
scaleControl.addTo(mapTwo);
scaleControl.addTo(mapThree);
let marker;
mapOne.on('click', function(e) {
    console.clear();
    if(marker) mapOne.removeLayer(marker);
    position = e.latlng;
    let loc1 = e.latlng.lat;
    let loc2 = e.latlng.lng;
    marker = L.marker(e.latlng).addTo(mapOne);
    $("input[name=location1]").val(loc1);
    $("input[name=location2]").val(loc2);
    let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address";
    let token = "9c9a6d48fabaaa617279d5fdb10ea468caf66c41";
    let query = { lat: loc1, lon: loc2, radius_meters: 500 };
    let options = {
        method: "POST",
        mode: "cors",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Token " + token
        },
        body: JSON.stringify(query)
    }
    let adr;
    let ad = '';
    function adres (address) {
        adr = address;
        console.log(typeof adr);
        let length = adr.length;
        console.log(length);
        let i = 0;
        let write;
        while (i != length) {
            i++;
            if (adr[i] == 'г') {
                write = true;
            }
            if (write) {
                if (adr[i] != '"') {
                    ad += adr[i];
                }
                else {break;}
            }
        }
        $("input[name=adres]").val(ad);
    }
    fetch(url, options)
    .then(response => response.text())
    .then(result => adres(result))
    .catch(error => console.log("error", error));
});
// =============================================================
// =============================================================
// =============================================================
mapTwo.on('click', function(e) {
    console.clear();
    if(marker) mapTwo.removeLayer(marker);
    position = e.latlng;
    let loc1 = e.latlng.lat;
    let loc2 = e.latlng.lng;
    marker = L.marker(e.latlng).addTo(mapTwo);
    $("input[name=location1_p]").val(loc1);
    $("input[name=location2_p]").val(loc2);
    let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address";
    let token = "9c9a6d48fabaaa617279d5fdb10ea468caf66c41";
    let query = { lat: loc1, lon: loc2, radius_meters: 500 };
    let options = {
        method: "POST",
        mode: "cors",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Token " + token
        },
        body: JSON.stringify(query)
    }
    let adr;
    let ad = '';
    function adres (address) {
        adr = address;
        console.log(typeof adr);
        let length = adr.length;
        console.log(length);
        let i = 0;
        let write;
        while (i != length) {
            i++;
            if (adr[i] == 'г') {
                write = true;
            }
            if (write) {
                if (adr[i] != '"') {
                    ad += adr[i];
                }
                else {break;}
            }
        }
        $("input[name=adres2]").val(ad);
    }
    fetch(url, options)
    .then(response => response.text())
    .then(result => adres(result))
    .catch(error => console.log("error", error));
});
// =============================================================
// =============================================================
// =============================================================
mapThree.on('click', function(e) {
    console.clear();
    if(marker) mapThree.removeLayer(marker);
    position = e.latlng;
    let loc1 = e.latlng.lat;
    let loc2 = e.latlng.lng;
    marker = L.marker(e.latlng).addTo(mapThree);
    $("input[name=location1_p2]").val(loc1);
    $("input[name=location2_p2]").val(loc2);
    let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address";
    let token = "9c9a6d48fabaaa617279d5fdb10ea468caf66c41";
    let query = { lat: loc1, lon: loc2, radius_meters: 500 };
    let options = {
        method: "POST",
        mode: "cors",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Token " + token
        },
        body: JSON.stringify(query)
    }
    let adr;
    let ad = '';
    function adres (address) {
        adr = address;
        console.log(typeof adr);
        let length = adr.length;
        console.log(length);
        let i = 0;
        let write;
        while (i != length) {
            i++;
            if (adr[i] == 'г') {
                write = true;
            }
            if (write) {
                if (adr[i] != '"') {
                    ad += adr[i];
                }
                else {break;}
            }
        }
        $("input[name=adres3]").val(ad);
    }
    fetch(url, options)
    .then(response => response.text())
    .then(result => adres(result))
    .catch(error => console.log("error", error));
});