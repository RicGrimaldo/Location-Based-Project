@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cambio de contraseña') }}</div>

                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('changePasswordPost') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="new-password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña antigua') }}</label>

                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control" name="current-password" >

                                @if ($errors->has('current-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="new-password" class="col-md-4 col-form-label text-md-end">{{ __('Contaseña nueva') }}</label>

                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control" name="new-password" >

                                @if ($errors->has('new-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="new-password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contaseña nueva') }}</label>

                            <div class="col-md-6">
                                <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" >
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary show-alert-delete-box">
                                    {{ __('Guardar cambios') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection