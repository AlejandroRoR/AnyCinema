@extends('backend.layouts.app')

@section('title')
    {{ __('Salas de Cine') }}
@endsection

@section('page-head')
    {{ __('Salas de Cine') }}
@endsection

@section('content')
<div class="botones d-flex">
    <a href="{{ route('admin.rooms') }}" class="btn btn-info">{{ __('Volver') }}</a>
    <a href="{{ route('admin.rooms.edit', $sala->id) }}" class='editar btn btn-primary ms-2'><i
            class='fas fa-edit'></i> {{ __('Editar') }}</a>
</div>
    <div class="col-10 offset-1">

        
        <div class="mostrar mt-4">
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="mostrarsala d-flex justify-content-center mb-4">
                        <table>
                        @for ($i = 1; $i <= $sala->n_filas; $i++)
                            <tr>
                            @for ($j = 1; $j <= $sala->n_columnas; $j++)
                                <td class="p-1">
                                    <?php 
                                    $bandera = false;
                                    foreach ($ocupadas as $value) {
                                        if($i == $value->n_fila && $j == $value->n_columna){
                                            $bandera = true;
                                        }
                                    }    
                                    ?>
                                    @if (!$bandera)
                                        <img src="{{asset('imagenes/asientos/seat.png')}}" alt="Silla">
                                    @endif
                                </td>
                            @endfor
                            </tr>
                        @endfor
                        </table>
                    </div>
                    
                </li>
                <li class="list-group-item"><b>ID - </b>{{ $sala->id }}</li>
                <li class="list-group-item"><b>{{ __('Nº de Sala') }} - </b>{{ $sala->n_sala }}</li>
                <li class="list-group-item"><b>{{ __('Nº de Filas') }} - </b>{{ $sala->n_filas }}</li>
                <li class="list-group-item"><b>{{ __('Nº de Butacas') }} - </b>{{ $sala->n_columnas }}</li>
                <li class="list-group-item"><b>{{ __('CREADA') }} - </b>{{ $sala->created_at }}</li>
                <li class="list-group-item"><b>{{ __('ACTUALIZADA') }} - </b>{{ $sala->updated_at }}</li>
            </ul>
        </div>
    </div>

@endsection
