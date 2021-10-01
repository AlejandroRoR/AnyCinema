@extends('backend.layouts.app')

@section('title', 'ENTRADA')

@section('content')
    <div class="container">

        <div class="botones d-flex">
            <a href="{{ route('admin.tickets') }}" class="btn btn-info">Volver</a>
            <a href="{{ route('admin.tickets.edit', $entrada->id) }}" class='editar btn btn-primary ml-2'><i
                    class='fas fa-edit'></i> Editar</a>
            <form action="{{ route('admin.tickets.destroy', $entrada->id) }}" class="ml-2" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class='editar btn btn-danger'><i class='fas fa-trash '></i> Eliminar</button>
            </form>
        </div>
        <div class="mostrar mt-4">
            <ul class="list-group">
                <li class="list-group-item"><b>ID - </b>{{ $entrada->id }}</li>
                <li class="list-group-item"><b>ID VENTA - </b>{{ $entrada->id_venta }}</li>
                <li class="list-group-item"><b>ID SESION - </b>{{ $entrada->id_sesion }}</li>
                <li class="list-group-item"><b>FILA - </b>{{ $entrada->fila }}</li>
                <li class="list-group-item"><b>COLUMNA - </b>{{ $entrada->columna }}</li>
                <li class="list-group-item"><b>PRECIO - </b>{{ $entrada->precio }}</li>
                <li class="list-group-item"><b>CREADA - </b>{{ $entrada->created_at }}</li>
                <li class="list-group-item"><b>ACTUALIZADA - </b>{{ $entrada->updated_at }}</li>
            </ul>
        </div>

    </div>
       

@endsection
