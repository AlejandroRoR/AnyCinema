@extends('backend.layouts.app')

@section('title')
    {{ __('Carteleras') }}
@endsection

@section('page-head')
    {{ __('Carteleras') }}
@endsection

@section('content')
    <div class="col-md-12">
        <a href="{{ route('admin.carteleras') }}" class="btn btn-info mb-4">{{ __('Volver') }}</a>
        <div class="card">
            <form action="{{ route('admin.carteleras.update', $cartelera) }}" method="POST">
                @csrf
                @method('put')
                <div class="card-body">
                    <h4 class="card-title">{{ __('Editar Cartelera') }}</h4>
                    <hr>
                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Fecha Inicio') }}</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" value="{{ old('fini', $cartelera->fecha_inicio) }}"
                                name="fini">
                            @error('fini')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Fecha Fin') }}</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" value="{{ old('ffin', $cartelera->fecha_fin) }}"
                                name="ffin">
                            @error('ffin')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center my-4">
                        @if (session('errorFecha'))
                            <small class="text-danger mb-4">{{ session('errorFecha') }}</small>
                        @endif
                    </div>
                    <div class="border-top mt-5">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success text-white">{{ __('Actualizar') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
