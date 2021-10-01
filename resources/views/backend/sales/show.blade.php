@extends('backend.layouts.app')

@section('title')
    {{ __('Ventas') }}
@endsection

@section('page-head')
    {{ __('Ventas') }}
@endsection

@section('content')
<div class="botones d-flex">
    <a href="{{ route('admin.sales') }}" class="btn btn-info">{{ __('Volver') }}</a>
</div>
    <div class="container">

        
        <div class="mostrar mt-4">
            <ul class="list-group">
                <li class="list-group-item"><b>ID - </b>{{ $venta->id }}</li>
                <li class="list-group-item"><b>{{ __('Usuario') }} - </b>{{ $venta->email }}</li>
                <li class="list-group-item"><b>{{ __('Pelicula') }} - </b>{{ $peli[$venta->id] }}</li>
                <li class="list-group-item"><b>{{ __('Precio') }} - </b>{{ $venta->precio }}€</li>
                <li class="list-group-item"><b>{{ __('CREADA') }} - </b>{{ $venta->created_at }}</li>
                <li class="list-group-item"><b>{{ __('ACTUALIZADA') }} - </b>{{ $venta->updated_at }}</li>
            </ul>
        </div>
        <h3 class="text-center mt-5 mb-2">{{ __('ENTRADAS') }}</h3>
        <div class="tickets row">
            @foreach ($tickets as $entrada)
            <div class="col-2">
                <ul class="list-group mt-3">
                    <li class="list-group-item text-center bg-warning"><b class="text-white">{{ __('ENTRADA') }}</b></li>
                    <li class="list-group-item"><b>{{ __('Fila') }} - </b>{{ $entrada->fila }}</li>
                    <li class="list-group-item"><b>{{ __('Butaca') }} - </b>{{ $entrada->columna }}</li>
                    <li class="list-group-item text-center"><b>{{ $entrada->precio }} €</b></li>
                </ul>
            </div>
            @endforeach
        </div>
    </div>



@endsection
