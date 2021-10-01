@extends('backend.layouts.app')

@section('title', 'Edit')

@section('content')
    <div class="container">

        <div class="col-12 text-center">
            <h3>EDITAR VENTA</h3>
        </div>
        <div class="text-center col-8 offset-2">
            <form action="{{ route('admin.sales.update', $venta) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-group">
                    <label>ID - {{$venta->id}}</label>
                </div>
                <div class="form-group">
                    <label>Usuario</label>
                    <select name="iduser" class="form-control">
                        @foreach ($usuarios as $user)
                            <option value="{{ $user->id }}">{{ $user->nombre }} {{$user->apellidos}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>ID Pelicula</label>
                    <input type="text" class="form-control" value="{{$venta->id_pelicula}}" name="idpeli">
                </div>
                <div class="form-group">
                    <label>Precio</label>
                    <input type="text" class="form-control" value="{{$venta->precio}}" name="precio">
                </div>
                <div class="form-group">
                    <label>Fecha</label>
                    <input type="text" class="form-control" value="{{$venta->fecha}}" name="fecha">
                </div>
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('admin.sales') }}" class="btn btn-danger">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
