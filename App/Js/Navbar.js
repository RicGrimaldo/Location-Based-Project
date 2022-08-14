let latitude, longitude;
let flag = false;
const btnSubirArchivo = document.getElementById('btnSubirArchivo');
const bytesToMB = bytes => bytes / (1024 ** 2);
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

btnSubirArchivo.addEventListener('click', function(){
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
                if(dat2 != "\"error\""){
                    btnSubirArchivo.setAttribute('disabled','');
                    btnSubirArchivo.innerHTML = 
                        ` <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span>Cargando...</span>`;
                    setTimeout( function() {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Archivo subido correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#modal').modal('hide'); 
                        $('#secondModal').modal('show'); 
                        btnSubirArchivo.removeAttribute('disabled');
                        btnSubirArchivo.innerHTML = '';
                    }, 1500 );
                    
                    paintModal(dat2);
                }
                else console.log("Hubo un error");
            }
        });
    }
});

const fileValidation = function(){
    let file_type = document.querySelector('input[name=file]:checked').value;
    var fileInput = document.getElementById('formFile');
    var file_data = $('#formFile').prop('files')[0];    
    var filePath = fileInput.value;
    console.log(bytesToMB(file_data.size));
    let allowedExtensions;
    switch(file_type){
        case '3DObj':
            allowedExtensions = /(.gltf|.glb|.zip)$/i;
            if(!allowedExtensions.exec(filePath)){
                showAlert('Debes ingresar una extensión válida (.gltf, .glb, .zip)', 'error');
                fileInput.value = '';
                return false;
            }
            else if(bytesToMB(file_data.size) > 50){
                showAlert('El tamaño del archivo rebasa los 50MB, escoge un archivo más pequeño.', 'error');
                fileInput.value = '';
                return false;
            }
            break;
        case 'img':
            allowedExtensions = /(.jpg|.png|.jpeg|.gif)$/i;
            if(!allowedExtensions.exec(filePath)){
                showAlert('Debes ingresar una extensión válida (.png, .jpg, .jpeg, .gif)', 'error');
                fileInput.value = '';
                return false;
            }
            else if(bytesToMB(file_data.size) > 10){
                showAlert('El tamaño del archivo rebasa los 10MB, escoge una imagen más pequeña.', 'error');
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
            else if(bytesToMB(file_data.size) > 25){
                showAlert('El tamaño del archivo rebasa los 25MB, escoge un video más pequeño.', 'error');
                fileInput.value = '';
                return false;
            }
            break;
        case 'txt&img':
            allowedExtensions = /(.jpg|.png|.jpeg|.gif)$/i;
            if(!allowedExtensions.exec(filePath)){
                showAlert('Debes ingresar una extensión válida (.png, .jpg, .jpeg, .gif)', 'error');
                fileInput.value = '';
                return false;
            }
            else if(bytesToMB(file_data.size) > 10){
                showAlert('El tamaño del archivo rebasa los 10MB, escoge una imagen más pequeña.', 'error');
                fileInput.value = '';
                return false;
            }
            break;
    }
    return true;
}

function paintModal(fileName){
    document.getElementById('savedImg').src = './Files/' + JSON.parse(fileName);
}

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