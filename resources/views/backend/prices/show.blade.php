@extends('backend.layouts.app')

@section('title')
    {{ __('Planes de Pago') }}
@endsection

@section('page-head')
    {{ __('Planes de Pago') }}
@endsection

@section('content')
    <div class="botones d-flex">
        <a href="{{ route('admin.prices') }}" class="btn btn-info">{{ __('Volver') }}</a>
        <a href="{{ route('admin.prices.edit', $precio->id) }}" class='editar btn btn-primary ms-2'><i
                class='fas fa-edit'></i> {{ __('Editar') }}</a>
    </div>
    <div class="col-10 offset-1">
        <div class="mostrar mt-4">
            <ul class="list-group">
                <li class="list-group-item"><b>ID - </b>{{ $precio->id }}</li>
                <li class="list-group-item"><b>{{ __('Nombre') }} - </b>{{ $precio->nombre }}</li>
                <li class="list-group-item"><b>{{ __('Precio') }} - </b>{{ $precio->precio }} €</li>
                <li class="list-group-item"><b>{{ __('Lunes') }} - </b>{{ $precio->lunes == 1 ? 'Si' : 'No' }}</li>
                <li class="list-group-item"><b>{{ __('Martes') }} - </b>{{ $precio->martes == 1 ? 'Si' : 'No' }}</li>
                <li class="list-group-item"><b>{{ __('Miercoles') }} - </b>{{ $precio->miercoles == 1 ? 'Si' : 'No' }}</li>
                <li class="list-group-item"><b>{{ __('Jueves') }} - </b>{{ $precio->jueves == 1 ? 'Si' : 'No' }}</li>
                <li class="list-group-item"><b>{{ __('Viernes') }} - </b>{{ $precio->viernes == 1 ? 'Si' : 'No' }}</li>
                <li class="list-group-item"><b>{{ __('Sabado') }} - </b>{{ $precio->sabado == 1 ? 'Si' : 'No' }}</li>
                <li class="list-group-item"><b>{{ __('Domingo') }} - </b>{{ $precio->domingo == 1 ? 'Si' : 'No' }}</li>
                <li class="list-group-item"><b>{{ __('Fecha') }} - </b>{{ $precio->fecha != '' ? $precio->fecha : 'No hay fecha' }}
                </li>
                <li class="list-group-item"><b>{{ __('CREADA') }} - </b>{{ $precio->created_at }}</li>
                <li class="list-group-item"><b>{{ __('ACTUALIZADA') }} - </b>{{ $precio->updated_at }}</li>
            </ul>
        </div>
    </div>


@endsection
