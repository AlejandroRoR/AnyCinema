@extends('backend.layouts.app')

@section('title')
    {{ __('Carteleras') }}
@endsection

@section('page-head')
    {{ __('Carteleras') }}
@endsection

@section('content')

    <div class="botones d-flex">
        <a href="{{ route('admin.carteleras') }}" class="btn btn-info">{{ __('Volver') }}</a>
        <a href="{{ route('admin.carteleras.edit', $cartelera->id) }}" class='editar btn btn-primary ms-2'><i
                class='fas fa-edit'></i> {{ __('Editar') }}</a>
    </div>
    <div class="col-10 offset-1">
        <div class="mostrar mt-4">
            <ul class="list-group">
                <li class="list-group-item"><b>ID - </b>{{ $cartelera->id }}</li>
                <li class="list-group-item"><b>{{ __('Fecha Inicio') }} - </b>{{ $cartelera->fecha_inicio }}</li>
                <li class="list-group-item"><b>{{ __('Fecha Fin') }} - </b>{{ $cartelera->fecha_fin }}</li>
                <li class="list-group-item"><b>{{ __('CREADA') }} - </b>{{ $cartelera->created_at }}</li>
                <li class="list-group-item"><b>{{ __('ACTUALIZADA') }} - </b>{{ $cartelera->updated_at }}</li>
            </ul>
        </div>
        <div class="peliculas row">
            @foreach ($pelis as $mov)
                <div class="col-2 mt-3">
                    <img src="https://image.tmdb.org/t/p/w500/{{ $mov['poster_path'] }}" class="img-fluid" alt="peli">
                </div>
            @endforeach
        </div>
    </div>

@endsection
