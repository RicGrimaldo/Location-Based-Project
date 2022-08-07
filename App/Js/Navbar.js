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
        // document.getElementById('texto1').innerHTML = document.getElementById('caja').getAttribute('gps-projected-entity-place');
        document.getElementById('caja').setAttribute('gps-projected-entity-place', `latitude: ${position.coords.latitude}; longitude: ${position.coords.longitude};`)
        // document.getElementById('texto1').innerHTML = document.getElementById('caja').getAttribute('gps-projected-entity-place');
    });
});