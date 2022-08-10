let latitude, longitude;
let flag = false;
(() => {
    'use strict'
    document.querySelector('#navbarSideCollapse').addEventListener('click', () => {
        document.querySelector('.offcanvas-collapse').classList.toggle('open');
        document.getElementById('navbar').classList.toggle('open');
        document.getElementById('menu-icon').classList.toggle('toggle');
        var menuIcon = document.getElementById('menu-icon');
        if(menuIcon.classList.contains('toggle')){
            menuIcon.src="Assets/menu-icon.png";
        }
        else{
            menuIcon.src = "Assets/x-lg.svg";
        }
    })
})()

document.addEventListener('DOMContentLoaded', function() {
    navigator.geolocation.watchPosition((position) => {
        document.getElementById('latitude').innerHTML = `Latitud: ` + position.coords.latitude.toFixed(7);
        document.getElementById('longitude').innerHTML = `Longitud: ` + position.coords.longitude.toFixed(7);
        latitude = position.coords.latitude.toFixed(7);
        longitude =  position.coords.longitude.toFixed(7);
    });
});

document.getElementById('btnSubirArchivo').addEventListener('click', function(){
    if(!flag){
        let scene = document.querySelector('a-scene');
        var model = document.createElement("a-image");
        model.setAttribute('gps-entity-place', `latitude:`+ latitude + `; longitude: ` + longitude);
        model.setAttribute('look-at', '[gps-camera]');
        model.setAttribute('scale', '2 2 2');
        model.setAttribute('src','./Assets/libro.png');
        scene.appendChild(model);
        flag = true;
    }
});