@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Ubicaciones guardadas</h4>
    <hr>
    <div class="row" id="cards">
        @foreach ($ubications as $ubication)
            <div class="col-12 mb-2 col-md-4">
                <div class="card h-100 text-bg-light">
                    <h3 class="card-header bg-transparent">Etiqueta: {{ $ubication->tag }}</h3>
                    <div id="file_view">
                        @php($file_type = $ubication->file_type)
                        @if($file_type == 'img')
                            <img src="{{ asset($ubication->file) }}" 
                            class="card-img-top w-100" 
                            alt="">
                        @elseif($file_type == '3DObj')
                            <div id="div3D">
                                <model-viewer 
                                    src="{{ asset($ubication->file) }}"
                                    camera-controls 
                                    auto-rotate 
                                    disable-zoom>
                                </model-viewer>
                            </div>
                        @elseif($file_type == 'video')
                            <div class="ratio ratio-16x9">
                                <video controls>
                                    <source src="{{ asset($ubication->file) }}" type="video/mp4">
                                    Tu navegador no soporta la etiqueta video.
                                </video>
                            </div>
                        @elseif($file_type == 'txt')
                        <p class="card-text">{{ $ubication->text }}</p>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5>Tipo: {{ $ubication->file_type }}</h5>
                        <p id="latitude">{{ $ubication->latitude }}</p>
                        <p id="longitude">{{ $ubication->longitude }}</p>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-danger" style="float: right;" data-id="{{ $ubication->id }}">Eliminar</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{ $ubications->links() }}

@endsection