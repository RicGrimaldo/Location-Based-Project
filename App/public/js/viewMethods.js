let latitude, longitude;
//  Displaying user real-time position 
document.addEventListener('DOMContentLoaded', function() {
        navigator.geolocation.watchPosition((position) => {
            document.getElementById('latitude').innerHTML = `Latitud: ` + position.coords.latitude.toFixed(7);
            document.getElementById('longitude').innerHTML = `Longitud: ` + position.coords.longitude.toFixed(7);
            latitude = position.coords.latitude.toFixed(7);
            longitude =  position.coords.longitude.toFixed(7);
            console.log("Latitude: " + latitude + ", longitude: " + longitude );
        });
});