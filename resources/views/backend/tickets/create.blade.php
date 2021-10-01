@extends('backend.layouts.app')

@section('title', 'Create')

@section('content')
    <div class="container">

        <div class="col-12 text-center">
            <h3>CREAR ENTRADA</h3>
        </div>
        <div class="botones">
            <a href="{{ route('admin.tickets') }}" class="btn btn-info">Volver</a>
        </div>

        <div class="text-center col-8 offset-2">
            @if (count($ventas) == 0 || count($sesiones) == 0)
                <p>Para crear entradas hace falta una sesión y una venta.</p>
            @else
                <form action="{{ route('admin.tickets.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>ID Ventas</label>
                        <select name="venta" class="form-control">
                            @foreach ($ventas as $sale)
                                <option value="{{ $sale->id }}">{{ $sale->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sesión</label>
                        <select name="sesion" class="form-control">
                            @foreach ($sesiones as $sesion)
                                <option value="{{ $sesion->id }}">{{ $sesion->hora }} / {{$sesion->fecha}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fila</label>
                        <input type="text" class="form-control" name="row">
                    </div>
                    <div class="form-group">
                        <label>Columna</label>
                        <input type="text" class="form-control" name="col">
                    </div>
                    <div class="form-group">
                        <label>Precio</label>
                        <input type="text" class="form-control" name="precio">
                    </div>
                    <button type="submit" class="btn btn-success">Crear Entrada</button>
                </form>
            @endif
        </div>
    </div>
@endsection
