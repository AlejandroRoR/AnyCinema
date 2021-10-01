@extends('backend.layouts.app')

@section('title', 'Create')

@section('content')
    <div class="container">

        <div class="col-12 text-center">
            <h3>CREAR VALORACIÓN</h3>
        </div>
        <div class="botones">
            <a href="{{ route('admin.ratings') }}" class="btn btn-info">Volver</a>
        </div>

        <div class="text-center col-8 offset-2">
            @if (count($usuarios) == 0 )
                <p>Para crear sesiones hace falta una sala de cine y una cartelera.</p>
            @else
                <form action="{{ route('admin.ratings.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Usuario</label>
                        <select name="iduser" class="form-control">
                            @foreach ($usuarios as $user)
                                <option value="{{ $user->id }}">{{ $user->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ID Pelicula</label>
                        <input type="text" class="form-control" name="idpeli">
                    </div>
                    <div class="form-group">
                        <label>Puntuación</label>
                        <select name="npunt" class="form-control">
                            @for ($i = 0; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Comentario</label>
                        <textarea name="coment" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Crear Valoración</button>
                </form>
            @endif
        </div>
    </div>
@endsection
