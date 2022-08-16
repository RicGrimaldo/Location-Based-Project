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
    let file;
    for(var i = 0; i < ubications.length; i++){
        let scene = document.querySelector('a-camera');
        file = `<a-image
                src="${ubications[i].route_file}"
                scale="1 1 1"
                gps-entity-place="latitude:${ubications[i].latitude}; longitude: ${ubications[i].longitude}"
            ></a-image>`;
        scene.outerHTML += file;
        alert(file);
    }
}