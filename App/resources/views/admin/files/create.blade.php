@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('files.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                <div class="row">
                    <h1>Subir archivo</h1>
                </div>
            </div>
        </div>

        <div class="row offset-2 d-flex justify-content-center">
            <label for="file-upload" class="contenedor-btn-file">
                <i class="fas fa-file"></i> Seleccionar archivo
            </label>
            <input id="file-upload" onchange='cambiar()' type="file" style='display: none;'/>
            <!-- <button class="contenedor-btn-file">
                <i class="fas fa-file"></i>
                Adjuntar archivo
                <label for="btn-file"></label>
                <input type="file" id="btn-file">
            </button> -->

            @error('file')
                <strong>{{ $message }}</strong>
            @enderror
        </div>

        <div class="row pt-4 offset-2">
            <button class="btn btn-primary" type="submit">Subir archivo</button>
        </div>
    </form>
    
</div>
@endsection
@section('js')

@endsection