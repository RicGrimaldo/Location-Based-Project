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
    // if(!flag){
    //     let scene = document.querySelector('a-scene');
    //     var model = document.createElement("a-image");
    //     model.setAttribute('gps-entity-place', `latitude:`+ latitude + `; longitude: ` + longitude);
    //     model.setAttribute('look-at', '[gps-camera]');
    //     model.setAttribute('scale', '2 2 2');
    //     model.setAttribute('src','./Assets/libro.png');
    //     scene.appendChild(model);
    //     flag = true;
    // }
    if(fileValidation()){

        let file_type = document.querySelector('input[name=file]:checked').value;

        var filename = (parseInt(Math.random()*(999999999999 - 100000000) + 100000000)).toString();   
        var file_data = $('#formFile').prop('files')[0];    
        var form_data = new FormData();
        form_data.append("file",file_data);
        form_data.append("filename",filename);

        $.ajax({
            url: "./PHP/validateFile.php",                      
                    type: "POST",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                success:function(dat2){
                    setTimeout( function() { 
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Archivo subido correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }, 1500 );
                }
        });
        $("#btnClose").click();
    }
    else{
        //  How to not display the second modal
        document.getElementById('secondModal').style.display = "none";
    }

});

const fileValidation = function(){
    let file_type = document.querySelector('input[name=file]:checked').value;
    var fileInput = document.getElementById('formFile');
    var filePath = fileInput.value;
    let text, allowedExtensions;
    switch(file_type){
        case '3DObj':
            allowedExtensions = /(.gltf|.glb|.zip)$/i;
            if(!allowedExtensions.exec(filePath)){
                showAlert('Debes ingresar una extensión válida (.gltf, .glb, .zip)', 'error');
                fileInput.value = '';
                return false;
            }
            break;
        case 'img':
            allowedExtensions = /(.jpg|.png|.gif)$/i;
            if(!allowedExtensions.exec(filePath)){
                showAlert('Debes ingresar una extensión válida (.png, .jpg, .gif)', 'error');
                fileInput.value = '';
                return false;
            }
            break;
        case 'video':
            allowedExtensions = /(.mp4)$/i;
            if(!allowedExtensions.exec(filePath)){
                showAlert('Debes ingresar una extensión válida (.mp4)', 'error');
                fileInput.value = '';
                return false;
            }
            break;
        case 'txt&img':
            allowedExtensions = /(.jpg|.png|.gif)$/i;
            if(!allowedExtensions.exec(filePath)){
                showAlert('Debes ingresar una extensión válida (.png, .jpg, .gif)', 'error');
                fileInput.value = '';
                return false;
            }
            break;
    }
    return true;
}

function showAlert(message, status){
    if(status.toLowerCase() == 'error'){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
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