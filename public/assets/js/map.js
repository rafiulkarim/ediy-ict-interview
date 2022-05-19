const myMap = L.map('map').setView([23.6850, 90.3563], 6);
const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const attribution =
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Coded by coder\'s gyan with ❤️';
const tileLayer = L.tileLayer(tileUrl, {attribution});
tileLayer.addTo(myMap);

function layerRemove(){
    myMap.eachLayer(function (layer) { myMap.removeLayer(layer); });
    tileLayer.addTo(myMap);

}

function goDivision(p, div) {
    layerRemove();
    division.forEach((d) => {
        if (d.name === div) {
            flyDivision(p, d);
        }
    })
    for (var i=0; i<Object.keys(divisions.features).length; i++){
        if (divisions.features[i].properties.ADM1_EN === div) {
            var a = L.geoJson(divisions.features[i].geometry).addTo(myMap);
        }
    }

}

function flyDivision(p, d) {
    const marker = L.marker([d.lat, d.long]).addTo(myMap);
    const point = L.popup({offset: L.point(0, -8)})
        .setLatLng([d.lat, d.long])
        .setContent('<b>Division:</b> '+ d.name +' <b>Population:</b> ' + p)
    popUpEvent(marker, point, p, d);
    myMap.flyTo([d.lat, d.long], 7, {
        duration: 1
    });
}

function goDistrict(p, dis){
    console.log(p, dis);
    layerRemove();
    district.forEach((d) => {
        if (d.name === dis) {
            flyDistrict(p, d);
        }
    })
    for (var i=0; i<Object.keys(districts.features).length; i++){
        if (districts.features[i].properties.ADM2_EN === dis) {
            var a = L.geoJson(districts.features[i].geometry).addTo(myMap);
        }
    }
}

function flyDistrict(p, d) {
    const marker = L.marker([d.lat, d.long]).addTo(myMap);
    const point = L.popup({offset: L.point(0, -8)})
        .setLatLng([d.lat, d.long])
        .setContent('<b>District:</b> '+ d.name +' <b>Population:</b> ' + p)
    popUpEvent(marker, point, p, d);

    myMap.flyTo([d.lat, d.long], 8, {
        duration: 1
    });
}

function popUpEvent(marker, point, p, d){
    marker.bindPopup(point)
    marker.on("mouseover", function(evt) { this.openPopup(); });
    marker.on("mouseout", function(evt) { this.closePopup(); });

    marker.on('mouseover', () =>{
        point.openPopup(myMap);
    });

    marker.on('mouseout', () =>{
        point.closePopup(myMap)
    });

    myMap.flyTo([d.lat, d.long], 7, {
        duration: 1
    });
}

