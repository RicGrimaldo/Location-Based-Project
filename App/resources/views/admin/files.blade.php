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
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">
                                This is a longer card with supporting text below as a natural lead-in to
                                additional content. This content is a little bit longer.
                                </p>
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