@extends('backend.layouts.app')

@section('title', 'Edit')

@section('content')
    <div class="container">

        <div class="col-12 text-center">
            <h3>EDITAR SESION</h3>
        </div>
        <div class="text-center col-8 offset-2">
            <form action="{{ route('admin.ratings.update', $valoracion) }}" method="POST">
                @csrf
                @method('put')

                <div class="form-group">
                    <label>ID - {{ $valoracion->id }}</label>
                </div>

                <div class="form-group">
                    <label>Usuario</label>
                    <select name="iduser" class="form-control">
                        @foreach ($usuarios as $user)
                            <option value="{{ $user->id }}" <?= $valoracion->id_user == $user->id ? 'selected' : '' ?>>{{ $user->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>ID Pelicula</label>
                    <input type="text" class="form-control" value="{{ $valoracion->id_pelicula }}" name="idpeli">
                </div>

                <div class="form-group">
                    <label>Puntuación</label>
                    <select name="npunt" class="form-control">
                        @for ($i = 0; $i <= 10; $i++)
                        <option value="{{ $i }}" <?= $i == $valoracion->puntuacion ? 'selected' : '' ?>>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label>Comentario</label>
                    <textarea name="coment" class="form-control" rows="3">{{ $valoracion->comentario }}</textarea>
                </div>
                
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('admin.ratings') }}" class="btn btn-danger">Cancelar</a>
            </form>
        </div>
    </div>


@endsection
