let latitude, longitude;
let flag = false;
const btnUploadFile = document.getElementById('btnUploadFile');
const btnSaveFile = document.getElementById('btnSaveFile');
const sourceFile = document.getElementById('sourceFile');
const bytesToMB = bytes => bytes / (1024 ** 2);
let ubications = [];

document.addEventListener('DOMContentLoaded', function() {
    if((localStorage.getItem('ubications'))){
        ubications = JSON.parse(localStorage.getItem('ubications'));
    }
});


// Ubication object
function Ubication(id, tag, file_type, latitude, longitude, route_file) {
    this.id = id;
    this.tag = tag;
    this.file_type = file_type;
    this.latitude = latitude;
    this.longitude = longitude;
    this.route_file = route_file;
}

function TmpFile(file_Name, file_type, route_file){
    this.file_Name = file_Name;
    this.file_type = file_type;
    this.route_file = route_file;
}

btnUploadFile.addEventListener('click', function(){
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
        var filename = (parseInt(Math.random()*(999999999999 - 100000000) + 100000000)).toString();   
        var file_data = $('#formFile').prop('files')[0];    
        let file_type = document.querySelector('input[name=file]:checked').value;
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
                    btnUploadFile.setAttribute('disabled','');
                    btnUploadFile.innerHTML = 
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
                        btnUploadFile.removeAttribute('disabled');
                        btnUploadFile.innerHTML = '';
                    }, 1500 );
                    paintModal(dat2, file_type);
                }
                else console.log("Hubo un error");
            }
        });
    }
});

btnSaveFile.addEventListener('click', function(){
    //  Comprobar que no esté vacío el input
    let tmp_file = JSON.parse(localStorage.getItem('ActualFile'));
    tag = document.getElementById('UbicationTag').value;
    if(value.length != 0){
        tmp_ubication = new Ubication(tmp_file.file_Name, tag, tmp_file.file_type, 
                                    latitude, longitude, tmp_file.route_file);
        console.log(tmp_ubication);
        ubications.push(tmp_ubication);
        localStorage.setItem('ubications',JSON.stringify(ubications));
        $('#secondModal').modal('hide'); 
        showAlert('Datos guardados correctamente', 'success');
        setTimeout( function() { window.location.href = "view.html"; }, 2500 );
    }
    else{
        showAlert("Debe ingresar una etiqueta", "error");
        document.getElementById('UbicationTag').focus();
    }
});

const fileValidation = function(){
    let file_type = document.querySelector('input[name=file]:checked').value;
    var fileInput = document.getElementById('formFile');
    var file_data = $('#formFile').prop('files')[0];    
    var filePath = fileInput.value;
    // console.log(bytesToMB(file_data.size));
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

function paintModal(fileName, file_type){
    let route_file = './Files/' + JSON.parse(fileName);
    let file;
    switch(file_type){
        case '3DObj':
            
            break;
        case 'img':
            file = `<img src="${route_file}" class="rounded mx-auto d-block" alt="Saved image" id="savedImg" width="150px">`;
            break;
        case 'video':
            file = `<div class="ratio ratio-16x9">
                        <video controls>
                        <source src="${route_file}" type="video/mp4">
                        Tu navegador no soporta la etiqueta video.
                        </video>
                    </div>`
            break;
    }
    document.getElementById('sourceFile').innerHTML = file;
    let tmp_file = new TmpFile(JSON.parse(fileName), file_type, route_file);
    localStorage.setItem('ActualFile', JSON.stringify(tmp_file));
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