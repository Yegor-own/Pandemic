'use srict'
const mapTwo = L.map('mapTwo').setView([56.8519000, 60.6122000], 13)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapTwo)
const mapThree = L.map('mapThree').setView([56.8519000, 60.6122000], 13)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapThree)
let marker
mapTwo.on('click', function(e) {
    console.clear()
    if(marker) mapTwo.removeLayer(marker)
    position = e.latlng
    let loc1 = e.latlng.lat
    let loc2 = e.latlng.lng
    marker = L.marker(e.latlng).addTo(mapTwo)
    $("input[name=loc_p]").val(loc1)
    $("input[name=loc2_p]").val(loc2)
    let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address"
    let token = "9c9a6d48fabaaa617279d5fdb10ea468caf66c41"
    let query = { lat: loc1, lon: loc2, radius_meters: 500 }
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
    let adr
    let ad = ''
    function adres (address) {
        adr = address
        console.log(typeof adr)
        let length = adr.length
        console.log(length)
        let i = 0
        let write
        while (i != length) {
            i++
            if (adr[i] == 'г') {
                write = true
            }
            if (write) {
                if (adr[i] != '"') {
                    ad += adr[i]
                }
                else {break}
            }
        }
        $("input[name=adres2]").val(ad)
    }
    fetch(url, options)
    .then(response => response.text())
    .then(result => adres(result))
    .catch(error => console.log("error", error))
})
// =============================================================
mapThree.on('click', function(e) {
    console.clear()
    if(marker) mapThree.removeLayer(marker)
    position = e.latlng
    let loc1 = e.latlng.lat
    let loc2 = e.latlng.lng
    marker = L.marker(e.latlng).addTo(mapThree)
    $("input[name=loc_p2]").val(loc1)
    $("input[name=loc2_p2]").val(loc2)
    let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address"
    let token = "9c9a6d48fabaaa617279d5fdb10ea468caf66c41"
    let query = { lat: loc1, lon: loc2, radius_meters: 500 }
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
    let adr
    let ad = ''
    function adres (address) {
        adr = address
        console.log(typeof adr)
        let length = adr.length
        console.log(length)
        let i = 0
        let write
        while (i != length) {
            i++
            if (adr[i] == 'г') {
                write = true
            }
            if (write) {
                if (adr[i] != '"') {
                    ad += adr[i]
                }
                else {break}
            }
        }
        $("input[name=adres3]").val(ad)
    }
    fetch(url, options)
    .then(response => response.text())
    .then(result => adres(result))
    .catch(error => console.log("error", error))
})