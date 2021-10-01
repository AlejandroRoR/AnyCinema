@extends('backend.layouts.app')

@section('title')
    {{ __('Sesiones') }}
@endsection

@section('page-head')
    {{ __('Sesiones') }}
@endsection

@section('content')

    <div class="botones d-flex">
        <a href="{{ route('admin.sessions') }}" class="btn btn-info">{{ __('Volver') }}</a>
        <a href="{{ route('admin.sessions.edit', $sesion->id) }}" class='editar btn btn-primary ms-2'><i
                class='fas fa-edit'></i> {{ __('Editar') }}</a>
    </div>

    <div class="col-10 offset-1">
        <div class="mostrar mt-4">
            <ul class="list-group">
                <li class="list-group-item"><b>ID - </b>{{ $sesion->id }}</li>
                <li class="list-group-item"><b>{{ __('Pelicula') }} - </b>{{ $titulo[0][0] }}</li>
                <li class="list-group-item"><b>{{ __('Nº de Sala') }} - </b>{{ $sesion->n_sala }}</li>
                <li class="list-group-item"><b>{{ __('Fecha') }} - </b>{{ $sesion->fecha }}</li>
                <li class="list-group-item"><b>{{ __('Hora') }} - </b>{{ $sesion->hora }}</li>
                <li class="list-group-item"><b>{{ __('Ocupada') }} - </b>{{ $sesion->agotada == 1 ? __('Si') : 'No' }}</li>
                <li class="list-group-item"><b>{{ __('CREADA') }} - </b>{{ $sesion->created_at }}</li>
                <li class="list-group-item"><b>{{ __('ACTUALIZADA') }} - </b>{{ $sesion->updated_at }}</li>
            </ul>
        </div>
    </div>

@endsection
