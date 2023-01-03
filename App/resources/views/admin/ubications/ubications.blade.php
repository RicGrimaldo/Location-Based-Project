<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Location Based Project') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
        <script src="https://unpkg.com/aframe-look-at-component@0.8.0/dist/aframe-look-at-component.min.js"></script>
        <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar-nft.js"></script>
        <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">

    <nav class="navbar navbar-expand-md navbar-light bg-white bg-transparent">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end bg-transparent" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('ubications') }}">Crear ubicación</a>

                                    <a class="dropdown-item" href="{{ route('ubications.list') }}">Lista de ubicaciones</a>

                                    <!-- Change password -->
                                    <a class="dropdown-item" href="{{ route('changePasswordGet') }}">Cambiar contraseña</a>

                                    <a class="dropdown-item" href="{{ route('files') }}">Lista de archivos</a>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar sesión') }}
                                    </a>
                                    

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
                <div id="location">
                    <p id="latitude"></p>
                    <p id="longitude"></p>
                </div>
            </div>
        </nav>

    <button class="btn buttonPlus" data-bs-toggle="modal" data-bs-target="#modal">
        <img src="/assets/Plus-icon.svg" width="40" height="40" id="plusBtn">
    </button>
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Selecciona el tipo de archivo: </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="file" id="3DObject" checked value="3DObj">
                            <label class="form-check-label" for="3DObject">
                                Objeto 3D (.gltf, .glb; tamaño máximo 50MB)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="file" id="image" value="img">
                            <label class="form-check-label" for="image">
                                Imagen (.png, .jpg, .jpeg, .gif; tamaño máximo 10MB)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="file" id="video" value="video">
                            <label class="form-check-label" for="video">
                                Video (.mp4; tamaño máximo 25MB)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="file" id="text" value="txt">
                            <label class="form-check-label" for="text">
                                Texto (máximo 200 caracteres)
                            </label>
                        </div>
                        <div class="mb-3" style="margin: 10px;">
                            <label for="formFile" class="form-label">Seleccionar un archivo de su dispositivo: </label>
                            <input class="form-control" type="file" id="formFile" name="fileUpload">
                        </div>
                        <p id="o">o</p>
                        <div class="mb-3">
                            <div>Seleccionar un archivo del servidor:</div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="button" id="btnViewFiles">Ver lista de archivos</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnClose">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnUploadFile">Subir archivo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="secondModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-bs-backdrop="static"> 
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Guardar ubicación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnClose2Modal"></button>
                </div>
                <form enctype="multipart/form-data" method="post" id="StoreFormData">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input name="tag" type="text" class="form-control" id="UbicationTag">
                            <label for="UbicationTag" id="tagLabel">Etiqueta para el archivo: </label>
                            @error('tag')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <p id="limitCharTag" class="limitChr"></p>
                        </div>
                        <p id="selectedTag">Archivo seleccionado: </p>
                        <div id="sourceFile"></div>
                        <div class="mb-3" id="txtAreaDiv">
                            <label for="txtArea" class="form-label">Ingrese el texto: </label>
                            <textarea name="textArea" class="form-control" id="txtArea" rows="8"></textarea>
                        </div>
                        <p id="limitChartxt" class="limitChr">0/200</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancel">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnSaveFile">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="fileListModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lista de archivos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="file_list">
                    <div class="row">
                        @foreach($files as $file)
                            <div class="card-group">
                                <div class="card h-100">
                                    @php
                                        $extension = pathinfo($file, PATHINFO_EXTENSION);
                                        $imgExtensions = array('jpg', 'jpeg', 'png', 'gif');
                                        $objExtensions = array('gltf','glb');
                                        $fl_type = '';
                                    @endphp
                                    @if(in_array($extension, $imgExtensions))
                                        @php($fl_type = 'img')
                                        <img src="storage/{{ $file }}" 
                                        class="card-img-top w-100" 
                                        alt="">
                                    @elseif(in_array($extension, $objExtensions))
                                        @php($fl_type = '3DObj')
                                        <div id="div3D">
                                            <model-viewer 
                                                src="storage/{{ $file }}"
                                                camera-controls 
                                                auto-rotate 
                                                disable-zoom>
                                            </model-viewer>
                                        </div>
                                    @elseif($extension == 'mp4')
                                        @php($fl_type = 'video')
                                        <div class="ratio ratio-16x9">
                                            <video controls>
                                                <source src="storage/{{ $file }}" type="video/mp4">
                                                Tu navegador no soporta la etiqueta video.
                                            </video>
                                        </div>
                                    @endif
                                    <div class="card-body text-end">
                                        <button 
                                            name="select_file" 
                                            type="button" 
                                            class="select_file btn btn-primary" 
                                            id="storage/{{ $file }}"
                                            value="{{ $fl_type }}">
                                        Seleccionar</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Siguiente</button>
                </div>
            </div>
        </div>
    </div>


    <a-scene
        vr-mode-ui="enabled: false"
        arjs='sourceType: webcam; videoTexture: true; debugUIEnabled: false;'
        renderer='antialias: true; alpha: true'>
        <a-assets></a-assets>
            <a-camera gps-projected-camera rotation-reader></a-camera>
            <div id="scene"></div>
    </a-scene>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/gps.js"></script>
    <script src="/js/ubicationsMethods.js"></script>
    </body>
</html>
