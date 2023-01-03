@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-md-flex justify-content-end mb-4 align-items-center align-items-baseline">
        <a href="{{ route('files.create') }}">
            <button class="contenedor-btn-file">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload me-2" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
            </svg>
                Subir archivo
            </button>
        </a>
    </div>
    <div class="row">
                @foreach($files as $file)
                    <div class="col-4 pb-4">
                        <div class="card h-100">
                            @php
                                $extension = pathinfo($file, PATHINFO_EXTENSION);
                                $imgExtensions = array('jpg', 'jpeg', 'png', 'gif');
                                $objExtensions = array('gltf','glb');
                            @endphp
                            @if(in_array($extension, $imgExtensions))
                                <img src="storage/{{ $file }}" 
                                class="card-img-top w-100" 
                                alt="">
                            @elseif(in_array($extension, $objExtensions))
                                <div id="div3D">
                                    <model-viewer 
                                        src="storage/{{ $file }}"
                                        camera-controls 
                                        auto-rotate 
                                        disable-zoom>
                                    </model-viewer>
                                </div>
                            @elseif($extension == 'mp4')
                                <div class="ratio ratio-16x9">
                                    <video controls>
                                        <source src="storage/{{ $file }}" type="video/mp4">
                                        Tu navegador no soporta la etiqueta video.
                                    </video>
                                </div>
                            @endif
                            <div class="card-footer">
                                <form action="{{ route('files.destroy', str_replace('Files/','',$file)) }}" 
                                    class="d-inline float-end" 
                                    method="POST"
                                    id="form-delete">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center">
                    {{ $files->links() }}
                </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('delete') == 'ok')

    <script>
        Swal.fire(
        '¡Eliminado!',
        'El archivo ha sido eliminado con éxito.',
        'success'
        )
    </script>

    @endif

    @if(session('upload') == 'ok')

    <script>
        Swal.fire(
        '¡Guardado!',
        'El archivo ha sido guardado con éxito.',
        'success'
        )
    </script>

    @endif

    <script>
        $('#form-delete').submit(function(e){
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro de eliminar el archivo?',
                text: "Se eliminará  definitivamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        })
    </script>
@endsection