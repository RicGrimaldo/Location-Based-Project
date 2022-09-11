let ubications = [];

// Ubication object
function Ubication(id, tag, file_type, latitude, longitude, route_file, text) {
    this.id = id;
    this.tag = tag;
    this.file_type = file_type;
    this.latitude = latitude;
    this.longitude = longitude;
    this.route_file = route_file;
    this.text = text;
}

document.addEventListener('DOMContentLoaded', function() {
    if (localStorage.getItem('ubications')) {
        loadUbications();
    }
    else{
        showAlert("No hay ninguna ubicación agregada.", "error");
    }
});

const loadUbications = function(){
    ubications = JSON.parse(localStorage.getItem('ubications'));
    paintCards();
}

const paintCards = function(){
    let file;
    let scene = document.getElementById('scene');
    for(var i = 0; i < ubications.length; i++){
        file = file_output(ubications[i], i);
        scene.innerHTML += file;
        alert(file);
    }
    $("#scene").contents().unwrap();
}

const file_output = function(ubication, i){
    let file;
    let asset = document.querySelector('a-assets');
    switch(ubication.file_type){
        case 'img':
            file = `<a-image
                src="${ubication.route_file}"
                scale="1 1 1"
                gps-entity-place="latitude:${ubication.latitude}; longitude: ${ubication.longitude}"
                id="${ubication.id}"
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
                gps-entity-place="latitude: ${ubication.latitude}; longitude: ${ubication.longitude};"
            ></a-video>`;
            break;
        case 'txt':
            file = `<a-text
            wrap-count="25"
            width="auto"
            value="${ubication.text}"
            look-at="[gps-camera]"
            align="center"
            anchor="center"
            baseline="center"
            gps-entity-place="latitude:${ubication.latitude}; longitude: ${ubication.longitude}"
            id="#${ubication.id}"
            ></a-text>`;
            break;
        case '3DObj':
            asset.innerHTML += `<a-asset-item 
                                    src="${ubication.route_file}"
                                    id="${ubication.id}">
                                </a-asset-item>`;
            file = `<a-entity
                    look-at="[gps-camera]"
                    rotation="0 360 0"
                    animation = "property: rotation; dur: 8000; easing: linear; dir: normal; from:0 0 0; to: 0 360 0; loop: false;"
                    animation-mixer="loop: repeat"
                    gps-entity-place="latitude:${ubication.latitude}; longitude: ${ubication.longitude}"
                    gltf-model="#${ubication.id}"
                    scale="0.5 0.5 0.5"
                    class="clickable"
                    gesture-handler 
                    > 
                </a-entity>`;
            break;
    }
    console.log(file);
    return file;
}