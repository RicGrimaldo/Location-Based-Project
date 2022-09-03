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
    let scene = document.getElementById('scene');
    for(var i = 0; i < ubications.length; i++){
        file = file_output(ubications[i]);
        scene.innerHTML += file;
        alert(file);
    }
    $("#scene").contents().unwrap();
}

const file_output = function(ubication){
    let file;
    let asset = document.querySelector('a-assets');
    switch(ubication.file_type){
        case 'img':
            file = `<a-image
                src="${ubication.route_file}"
                scale="1 1 1"
                gps-entity-place="latitude:${ubication.latitude}; longitude: ${ubication.longitude}"
            ></a-image>`;
            break;
        case 'video':
            asset.innerHTML += `<video
                    src="${ubication.route_file}"
                    preload="auto"
                    id="${ubication.id}"
                    response-type="arraybuffer"
                    crossorigin
                    muted
                    autoplay
                    height="240px"
                    loop
                ></video>`;
            file = `<a-video
                src="#${ubication.id}"
                position='0 0.1 0'
                videohandler
                smooth="true"
                smoothCount="10"
                smoothTolerance="0.01"
                smoothThreshold="5"
                autoplay="false"
                scale="1 1 1"
                gps-entity-place="latitude: latitude: ${ubication.latitude}; longitude: ${ubication.longitude};"
            ></a-video>`;
            break;
    }
    console.log(file);
    return file;
}