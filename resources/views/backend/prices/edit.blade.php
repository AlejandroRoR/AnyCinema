@extends('backend.layouts.app')

@section('title')
    {{ __('Planes de Pago') }}
@endsection

@section('page-head')
    {{ __('Planes de Pago') }}
@endsection

@section('content')
    <div class="col-md-12">
        <a href="{{ route('admin.prices') }}" class="btn btn-info mb-4">Volver</a>
        <div class="card">
            <form action="{{ route('admin.prices.update', $precio) }}" method="POST">
                @csrf
                @method('put')
                <div class="card-body">
                    <h4 class="card-title">{{ __('Editar Plan') }}</h4>
                    <hr>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Nombre') }}</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ old('name', $precio->nombre) }}"
                                name="name">
                            @error('name')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Precio') }}</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ old('price', $precio->precio) }}"
                                name="price">
                            @error('price')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Lunes') }}</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="form-check-input" name="lunes" value="1"
                                {{ old('lunes') == '1' || $precio->lunes ? 'checked' : '' }}>
                            @error('lunes')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Martes') }}</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="form-check-input" name="martes" value="1"
                                {{ old('martes') == '1' || $precio->martes ? 'checked' : '' }}>
                            @error('martes')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Miercoles') }}</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="form-check-input" name="miercoles" value="1"
                                {{ old('miercoles') == '1' || $precio->miercoles ? 'checked' : '' }}>
                            @error('miercoles')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Jueves') }}</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="form-check-input" name="jueves" value="1"
                                {{ old('jueves') == '1' || $precio->jueves ? 'checked' : '' }}>
                            @error('jueves')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Viernes') }}</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="form-check-input" name="viernes" value="1"
                                {{ old('viernes') == '1' || $precio->viernes ? 'checked' : '' }}>
                            @error('viernes')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Sabado') }}</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="form-check-input" name="sabado" value="1"
                                {{ old('sabado') == '1' || $precio->sabado ? 'checked' : '' }}>
                            @error('sabado')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Domingo') }}</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="form-check-input" name="domingo" value="1"
                                {{ old('domingo') == '1' || $precio->domingo ? 'checked' : '' }}>
                            @error('domingo')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Fecha') }}</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="fecha" placeholder="dd/mm/yyyy"
                                value="{{ old('fecha', $precio->fecha) }}">
                            @error('fecha')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success text-white">{{ __('Actualizar') }}</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

@endsection

