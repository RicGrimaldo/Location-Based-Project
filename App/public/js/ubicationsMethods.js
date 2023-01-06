let flagSelected = false;
const btnUploadFile = document.getElementById('btnUploadFile');
const btnSaveFile = document.getElementById('btnSaveFile');
const sourceFile = document.getElementById('sourceFile');
const UbicationTag = document.getElementById('UbicationTag');
const bytesToMB = bytes => bytes / (1024 ** 2);
let randomName = () => (parseInt(Math.random()*(999999999999 - 100000000) + 100000000)).toString();   
let ubications = [];
const limitCharTag = document.getElementById("limitCharTag");
const txtArea = document.getElementById('txtArea');
const limitChartxt = document.getElementById('limitChartxt');
const btnCancel = document.getElementById('btnCancel');
var form_data = new FormData();

document.addEventListener('DOMContentLoaded', function() {
    limitCharTag.textContent = 0 + "/" + 20;
});

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

function TmpFile(file_Name, file_type, route_file){
    this.file_Name = file_Name;
    this.file_type = file_type;
    this.route_file = route_file;
}

//  When a radio button is selected
$("input[name=file]").change(function () {	 
    if(($(this).val()) === 'txt'){
        $("#formFile").attr("disabled", "");
        btnUploadFile.innerText = 'Siguiente';
    } else{
        $("#formFile").removeAttr("disabled");
        btnUploadFile.innerText = 'Guardar archivo';
    }
});

//Upload File function
btnUploadFile.addEventListener('click', function(){
    //  In the case that the text option is selected, the process will be different of the file process
    if(($('input:radio[name=file]:checked').val()) === 'txt'){
        btnUploadFile.setAttribute('disabled','');
        btnUploadFile.innerHTML = 
            ` <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span>Cargando...</span>`;
        setTimeout( function() {
            $('#modal').modal('hide'); 
            $('#secondModal').modal('show'); 
            btnUploadFile.removeAttribute('disabled');
            btnUploadFile.innerHTML = '';
            btnUploadFile.innerText = 'Subir archivo';
        }, 1500 );
        //  It won't have a name, it's a text after all
        paintModalPreview(null, null, 'txt');
        return;
    }
    //  File validation will be done first (file size and extension file)
    if(fileValidation()){
        var filename = randomName();   
        var file_data = $('#formFile').prop('files')[0];    
        let file_type = document.querySelector('input[name=file]:checked').value;
        form_data.append("file",file_data);
        form_data.append("filename",filename);
        form_data.append("file_type",file_type);
        // Se listan los pares clave/valor
        for (var entrie of form_data.entries()) {
            console.log(entrie[0]+ ': ' + entrie[1]); 
        }
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
            btnUploadFile.innerText = 'Subir archivo';
        }, 1500 );
        paintModalPreview(file_data, filename, file_type);
    }
});

//  Before saving the file, the empty input validation occurs
btnSaveFile.addEventListener('click', function(){
    let text = '';
    let tag = '';
    tag = UbicationTag.value;
    if(tag.length == 0){
        showAlert("Debe ingresar una etiqueta", "error");
        UbicationTag.focus();
        return;
    }
    if(tag.length >= 20){
        showAlert("La etiqueta debe tener máximo 20 caracteres", "error");
        UbicationTag.focus();
        return;
    }
    //  In the case where the text was selected
    if($("#txtAreaDiv").css("display") === 'block'){
        text = $("#txtArea").val();
        //  TextArea empty validation
        if(text.length == 0){
            showAlert("Debe poner un texto", "error");
            $("#txtAreaDiv").focus();
            return;
        }
        file_name = randomName();
        file_type = 'txt';
        form_data.append("file_type",file_type);
    }
    //  To validate that the location is not close to another already saved.
    if(!ubicationValidation(latitude, longitude)){
        return;
    }
    //  The new file and location are uploaded
    // In the case of the text, the object only will have the ubication,
    // the tag, the file type and the text itself
    form_data.append("tag", tag);
    form_data.append("latitude", latitude);
    form_data.append("longitude", longitude);
    form_data.append("text", text);
    $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "/Ubications/",                      
            type: "POST",
            dataType: 'script',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            data: form_data,
            beforeSend: function(){
                btnSaveFile.setAttribute('disabled','');
                btnSaveFile.innerHTML = 
                    ` <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span>Cargando...</span>`;
            },
            complete: function(){
                btnSaveFile.removeAttribute('disabled');
                btnSaveFile.innerHTML = '';
                btnSaveFile.innerText = 'Guardar';
            },
            success: function(response){ 
                console.log('success: '+ JSON.stringify(response));
                $('#secondModal').modal('hide'); 
                showAlert('Datos guardados correctamente', 'success');
                setTimeout( function() { location.reload(); }, 2500 );
            },
            error: function (jqXHR) {
                //  In the case that the tag already exists
                if (jqXHR.status === 422) {
                    var errors = $.parseJSON(jqXHR.responseText);
                    $.each(errors, function (key, value) {
                        showAlert(value, 'error');
                    });
                }
            }
    });
});

//  File size and extension file validations
const fileValidation = function(){
    let file_type = document.querySelector('input[name=file]:checked').value;
    var fileInput = document.getElementById('formFile');
    var file_data = $('#formFile').prop('files')[0];    
    var filePath = fileInput.value;
    // console.log(bytesToMB(file_data.size));
    let allowedExtensions;
    switch(file_type){
        case '3DObj':
            allowedExtensions = /(.gltf|.glb)$/i;
            if(!allowedExtensions.exec(filePath)){
                showAlert('Debes ingresar una extensión válida (.gltf, .glb)', 'error');
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
    }
    return true;
};

const ubicationValidation = function(lat, long){
    let form = new FormData();
    let flag = true;
    form.append("latitude", lat);
    form.append("longitude", long);
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "/Ubications/compare",                      
        type: "POST",
        dataType: 'script',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'JSON',
        async: false,
        data: form,
        success: function(response){ 
            console.log(JSON.stringify(response));
            flag = true;
        },
        error: function (jqXHR) {
            //  In the case that the tag already exists
            if (jqXHR.status === 422) {
                var errors = $.parseJSON(jqXHR.responseText);
                $.each(errors, function (key, value) {
                    showAlert(value, 'error');
                });
                flag = false;
            }
            if (jqXHR.status === 404) {
                var errors = $.parseJSON(jqXHR.responseText);
                $.each(errors, function (key, value) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                    })
                    Toast.fire({
                        icon: 'warning',
                        title: value
                    })
                });
                flag = false;
            }
        }
    });
    console.log(flag);
    return flag;
};

//  In the case that a server file is selected
$(document).on('click', '.select_file', function(){
    var selectedFilePath = $(this).attr("id");
    var file_type = $(this).attr("value");
    flagSelected = true;
    form_data.append("file_type",file_type);
    form_data.append("selectedFilePath", selectedFilePath);
    $('#fileListModal').modal('hide'); 
    btnUploadFile.setAttribute('disabled','');
    showAlert("Archivo seleccionado", "success");
    btnUploadFile.innerHTML = 
        ` <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span>Cargando...</span>`;
    setTimeout( function() {
        $('#modal').modal('hide'); 
        $('#secondModal').modal('show'); 
        btnUploadFile.removeAttribute('disabled');
        btnUploadFile.innerHTML = '';
        btnUploadFile.innerText = 'Subir archivo';
    }, 1500 );
    paintModalPreview(selectedFilePath, '"'+randomName()+'"', file_type);
});

function paintModalPreview(file_data, filename, file_type){
    var fileCodified;
    if(file_type != 'txt'){ 
        //  In the case that a server's file was selected and already exists a path for the file
        if(flagSelected){
            flagSelected = false;
            fileCodified = file_data;
        }
        //  In the case to show a preview of the file that will be uploaded
        else{
            var fileCodified = URL.createObjectURL(file_data);
        }
        $('#txtAreaDiv').css("display","none");
        $('#limitChartxt').css("display","none");
    }
    else {
        $('#selectedTag').remove();
        $('#sourceFile').remove();
        $('#tagLabel').text("Etiqueta para el texto: ");
        $('#txtAreaDiv').css("display","block");
        $('#limitChartxt').css("display","block");
        return;
    }
    let file = '';
    switch(file_type){
        case '3DObj':
            file = `<div id="div3D">
                        <model-viewer src="${fileCodified}" camera-controls auto-rotate disable-zoom id="${filename}"></model-viewer>
                    </div>`;
            break;
        case 'img':
            file = `<img src="${fileCodified}" class="rounded mx-auto d-block" alt="Saved image" id="${filename}"" width="150px">`;
            break;
        case 'video':
            file = `<div class="ratio ratio-16x9">
                        <video controls>
                        <source src="${fileCodified}" type="video/mp4" id="${filename}">
                        Tu navegador no soporta la etiqueta video.
                        </video>
                    </div>`
            break;
    }
    //  The new file tag will be shown in the modal
    document.getElementById('sourceFile').innerHTML = file;
}

//  When the user cancels the uploading file action
btnCancel.addEventListener('click', function(){
    form_data = new FormData();
    document.getElementById('sourceFile').innerHTML = '';
    document.getElementById('formFile').value = '';
});

//  To display the list of the server files.
document.getElementById('btnViewFiles').addEventListener('click',function(){
    $("#fileListModal").modal("show");
});

//  Limit Character for the ubication tag
UbicationTag.addEventListener('input', function(){
    limitChar(UbicationTag, limitCharTag, 20);
});

//  limit Character for the textArea
document.getElementById('txtArea').addEventListener('input', function(){
    limitChar(txtArea,limitChartxt, 200);
})

//  Limit characters of an input
function limitChar(input, result, limit){
    var textLength = input.value.length;
    result.textContent = textLength + "/" + limit;

    if(textLength > limit){
        input.style.borderColor = "#ff2851";
        result.style.color = "#ff2851";
    }
    else{
        input.style.borderColor = "#b2b2b2";
        result.style.color = "#737373";
    }
}