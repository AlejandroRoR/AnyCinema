@extends('backend.layouts.app')

@section('title', 'Edit')

@section('content')
    <div class="container">

        <div class="col-12 text-center">
            <h3>EDITAR ENTRADA</h3>
        </div>
        <div class="text-center col-8 offset-2">
            <form action="{{ route('admin.tickets.update', $entrada) }}" method="POST">
                @csrf
                @method('put')

                <div class="form-group">
                    <label>ID - {{ $entrada->id }}</label>
                </div>

                <div class="form-group">
                    <label>ID Ventas</label>
                    <select name="venta" class="form-control">
                        @foreach ($ventas as $sale)
                            <option value="{{ $sale->id }}" <?= $entrada->id_venta == $sale->id ? 'selected' : '' ?>>{{ $sale->id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Sesión</label>
                    <select name="sesion" class="form-control">
                        @foreach ($sesiones as $sesion)
                            <option value="{{ $sesion->id }}" <?= $entrada->id_sesion == $sesion->id ? 'selected' : '' ?>>{{ $sesion->hora }} / {{$sesion->fecha}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Fila</label>
                    <input type="text" class="form-control" value="{{ $entrada->fila }}" name="row">
                </div>
                <div class="form-group">
                    <label>Columna</label>
                    <input type="text" class="form-control" value="{{ $entrada->columna }}" name="col">
                </div>
                <div class="form-group">
                    <label>Precio</label>
                    <input type="text" class="form-control" value="{{ $entrada->precio }}" name="precio">
                </div>
                
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('admin.tickets') }}" class="btn btn-danger">Cancelar</a>
            </form>
        </div>
    </div>


@endsection
