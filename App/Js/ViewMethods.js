let ubications = [];

function Ubication(id, tag, file_type, latitude, longitude, route_file) {
    this.id = id;
    this.tag = tag;
    this.file_type = file_type;
    this.latitude = latitude;
    this.longitude = longitude;
    this.route_file = route_file;
}

document.addEventListener('DOMContentLoaded', function() {
    loadUbications();
});

const loadUbications = function(){
    ubications = JSON.parse(localStorage.getItem('ubications'));
    paintCards();
}

const paintCards = function(){
    for(var i = 0; i < ubications.length; i++){
        let scene = document.querySelector('a-scene');
        var model = document.createElement("a-image");
        model.setAttribute('id', ubications[i].id);
        model.setAttribute('look-at', '[gps-camera]');
        model.setAttribute('scale', '5 5 5');
        model.setAttribute('src',ubications[i].route_file);
        model.setAttribute('gps-entity-place', "latitude");
        model.setAttribute('gps-entity-place', {
            latitude: ubications[i].latitude,
            longitude: ubications[i].longitude
        });
        model.addEventListener('loaded', () => {
            window.dispatchEvent(new CustomEvent('gps-entity-place-loaded'))
        });
        scene.appendChild(model);
        console.log(model);
    }
}