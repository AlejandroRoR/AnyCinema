@extends('backend.layouts.app')

@section('title', 'Edit')

@section('content')

    <div class="col-md-12">
        <a href="{{ route('admin.sessions') }}" class="btn btn-info mb-3">{{ __('Volver') }}</a>
        <div class="card">
            <form action="{{ route('admin.sessions.update', $sesion) }}" method="POST">
                @csrf
                @method('put')
                <div class="card-body">
                    <h4 class="card-title">{{ __('Editar Sesión') }} - {{ $peli }}</h4>
                    <hr>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Sala') }}</label>
                        <div class="col-sm-4">
                            <select name="idsala" class="form-select">
                                <option>{{ __('Selecciona una sala') }}</option>
                                @foreach ($salas as $sala)
                                    <option value="{{ $sala->id }}"
                                        {{ $sala->id == $sesion->id_sala ? 'selected' : '' }}>{{ $sala->n_sala }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idsala')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Fecha') }}</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="fecha" placeholder="dd/mm/yyyy"
                                value="{{ old('fecha', $sesion->fecha) }}">
                            @error('fecha')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Hora') }}</label>
                        <div class="col-sm-4">
                            <input type="time" class="form-control" name="hora" value="{{ old('hora', $sesion->hora) }}">
                            @error('hora')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" id="botoncrear"
                                class="btn btn-success text-white">{{ __('Actualizar') }}</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

@endsection
