@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
                @foreach($files as $file)
                    <div class="col-4 pb-4">
                        <div class="card h-100">
                            <img src="storage/{{ $file }}" 
                            class="card-img-top w-100" 
                            alt="">
                            <div class="card-footer">
                                <form action="{{ route('files.destroy', str_replace('Files/','',$file)) }}" 
                                    class="d-inline float-end" 
                                    method="POST">
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