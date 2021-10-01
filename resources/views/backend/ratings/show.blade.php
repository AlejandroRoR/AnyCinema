@extends('backend.layouts.app')

@section('title')
    {{ __('Valoraciones') }}
@endsection

@section('page-head')
    {{ __('Valoraciones') }}
@endsection

@section('content')

    <div class="botones d-flex">
        <a href="{{ route('admin.ratings') }}" class="btn btn-info">{{ __('Volver') }}</a>
        {{-- <a href="{{ route('admin.ratings.edit', $valoracion->id) }}" class='editar btn btn-primary ml-2'><i
            class='fas fa-edit'></i> Editar</a>
    <form action="{{ route('admin.ratings.destroy', $valoracion->id) }}" class="ml-2" method="POST">
        @csrf
        @method('delete')
        <button type="submit" class='editar btn btn-danger'><i class='fas fa-trash '></i> Eliminar</button>
    </form> --}}
    </div>
    <div class="col-10 offset-1">
        <div class="mostrar mt-4">
            <ul class="list-group">
                <li class="list-group-item"><b>ID - </b>{{ $valoracion->id }}</li>
                <li class="list-group-item"><b>{{ __('Usuario') }} - </b>{{ $valoracion->email }}</li>
                <li class="list-group-item"><b>{{ __('Pelicula') }} - </b>{{ $peli[$valoracion->id] }}</li>
                <li class="list-group-item"><b>{{ __('Puntuación') }} - </b>{{ $valoracion->puntuacion }}</li>
                <li class="list-group-item"><b>{{ __('Comentario') }} - </b>{{ $valoracion->comentario }}</li>
                <li class="list-group-item"><b>{{ __('CREADA') }} - </b>{{ $valoracion->created_at }}</li>
                <li class="list-group-item"><b>{{ __('ACTUALIZADA') }} - </b>{{ $valoracion->updated_at }}</li>
            </ul>
        </div>
    </div>

@endsection
