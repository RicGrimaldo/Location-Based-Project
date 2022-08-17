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
    let scene = document.querySelector('a-camera');
    for(var i = 0; i < ubications.length; i++){
        file = file_output(ubications[i]);
        scene.outerHTML += file;
        alert(file);
    }
}

const file_output = function(ubication){
    let file;
    switch(ubication.file_type){
        case 'img':
            file = `<a-image
                src="${ubications[i].route_file}"
                scale="1 1 1"
                gps-entity-place="latitude:${ubications[i].latitude}; longitude: ${ubications[i].longitude}"
            ></a-image>`;
            return file;
        // case 'video':
        //     file = 
    }
}