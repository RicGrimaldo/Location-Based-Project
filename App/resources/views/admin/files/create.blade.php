@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('files.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <h1>Subir archivo</h1>
        <div class="d-grid gap-2">
            <div class="d-grid gap-2">
                <label for="file-upload" class="contenedor-btn-file">
                    <i class="fas fa-file"></i> Seleccionar archivo
                </label>
                <input id="file-upload" type="file" style='display: none;' name="file-upload" enctype="multipart/form-data"/>
                @error('file')
                    <strong>{{ $message }}</strong>
                @enderror
            </div>
            <button class="btn btn-primary" type="submit" id="btn-upload" disabled>Subir archivo</button>
        </div>
    </form>
    
</div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/files.js"></script>
@endsection