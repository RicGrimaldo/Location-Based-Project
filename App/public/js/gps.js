let latitude, longitude;
//  Displaying user real-time position 
document.addEventListener('DOMContentLoaded', function() {
        navigator.geolocation.watchPosition((position) => {
            document.getElementById('latitude').innerHTML = `Latitud: ` + position.coords.latitude.toFixed(7);
            document.getElementById('longitude').innerHTML = `Longitud: ` + position.coords.longitude.toFixed(7);
            latitude = position.coords.latitude.toFixed(7);
            longitude =  position.coords.longitude.toFixed(7);
            console.log(latitude + " y " +longitude);
        });
});

//  Depending of the status, a different message will be shown
function showAlert(message, status){
    if(status.toLowerCase() == 'error'){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500
        })
        Toast.fire({
            icon: 'warning',
            title: message
        })
    }
    else if(status.toLowerCase() == 'success'){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    
        Toast.fire({
            icon: 'success',
            title: message
        })
    }
}