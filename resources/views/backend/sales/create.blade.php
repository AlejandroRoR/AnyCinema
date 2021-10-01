@extends('backend.layouts.app')

@section('title', 'Create')

@section('content')
    <div class="container">

        <div class="col-12 text-center">
            <h3>CREAR VENTA</h3>
        </div>
        <div class="botones">
            <a href="{{ route('admin.sales') }}" class="btn btn-info">Volver</a>
        </div>
        <div class="text-center col-8 offset-2">
            <form action="{{ route('admin.sales.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Usuario</label>
                    <select name="iduser" class="form-control">
                        @foreach ($usuarios as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} {{$user->surname}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>ID Pelicula</label>
                    <input type="text" class="form-control" name="idpeli">
                </div>
                <div class="form-group">
                    <label>Precio</label>
                    <input type="text" class="form-control" name="precio">
                </div>
                <div class="form-group">
                    <label>Fecha</label>
                    <input type="date" class="form-control" name="fecha">
                </div>
                <button type="submit" class="btn btn-success">Crear Venta</button>
            </form>
        </div>
    </div>
@endsection
