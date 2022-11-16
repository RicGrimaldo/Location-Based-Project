const btnupload = document.getElementById('btn-upload');
const bytesToMB = bytes => bytes / (1024 ** 2);

$("#file-upload").change(function(){
    $("#btn-upload").prop("disabled", this.files.length == 0);
});

$( "form" ).submit(function( event ) {
    event.preventDefault();
    if(fileValidation()){
        this.submit();
    }
});

const fileValidation = function(){
    var fileInput = document.getElementById('file-upload');
    var file_data = $('#file-upload').prop('files')[0];    
    var filePath = fileInput.value;
    // console.log(bytesToMB(file_data.size));
    let allowedExtensions = /(.gltf|.glb|.jpg|.png|.jpeg|.gif|.mp4)$/i;;
    if(!allowedExtensions.exec(filePath)){
        showAlert('Debes ingresar una extensión válida', 'error');
        fileInput.value = '';
        return false;
    }
    // switch(file_type){
    //     case '3DObj':
    //         allowedExtensions = /(.gltf|.glb)$/i;
    //         if(!allowedExtensions.exec(filePath)){
    //             showAlert('Debes ingresar una extensión válida (.gltf, .glb)', 'error');
    //             fileInput.value = '';
    //             return false;
    //         }
    //         else if(bytesToMB(file_data.size) > 50){
    //             showAlert('El tamaño del archivo rebasa los 50MB, escoge un archivo más pequeño.', 'error');
    //             fileInput.value = '';
    //             return false;
    //         }
    //         break;
    //     case 'img':
    //         allowedExtensions = /(.jpg|.png|.jpeg|.gif)$/i;
    //         if(!allowedExtensions.exec(filePath)){
    //             showAlert('Debes ingresar una extensión válida (.png, .jpg, .jpeg, .gif)', 'error');
    //             fileInput.value = '';
    //             return false;
    //         }
    //         else if(bytesToMB(file_data.size) > 10){
    //             showAlert('El tamaño del archivo rebasa los 10MB, escoge una imagen más pequeña.', 'error');
    //             fileInput.value = '';
    //             return false;
    //         }
    //         break;
    //     case 'video':
    //         allowedExtensions = /(.mp4)$/i;
    //         if(!allowedExtensions.exec(filePath)){
    //             showAlert('Debes ingresar una extensión válida (.mp4)', 'error');
    //             fileInput.value = '';
    //             return false;
    //         }
    //         else if(bytesToMB(file_data.size) > 25){
    //             showAlert('El tamaño del archivo rebasa los 25MB, escoge un video más pequeño.', 'error');
    //             fileInput.value = '';
    //             return false;
    //         }
    //         break;
    // }
    return true;
}

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