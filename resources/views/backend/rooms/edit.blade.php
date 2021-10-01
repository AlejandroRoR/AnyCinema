@extends('backend.layouts.app')

@section('title')
    {{ __('Salas de Cine') }}
@endsection

@section('page-head')
    {{ __('Salas de Cine') }}
@endsection

@section('content')
    <div class="col-md-12">
        <a href="{{ route('admin.rooms') }}" class="btn btn-info mb-4">{{ __('Volver') }}</a>
        <div class="card">
            <form action="{{ route('admin.rooms.update', $sala) }}" method="POST">
                @csrf
                @method('put')
                <div class="card-body">
                    <h4 class="card-title">{{ __('Editar Sala') }}</h4>
                    <hr>
                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Nº de Sala') }}</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ old('nsala', $sala->n_sala) }}" name="nsala">
                            @error('nsala')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="tablero">


                        <div class="form-group row">
                            <label for="fname"
                                class="col-sm-4 text-end control-label col-form-label">{{ __('Nº de Filas') }}</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="nrow" value="{{ old('nrow', $sala->n_filas) }}" name="nrow">
                                @error('nrow')
                                    <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname"
                                class="col-sm-4 text-end control-label col-form-label">{{ __('Nº de Butacas') }}</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="ncol" value="{{ old('ncol', $sala->n_columnas) }}" name="ncol">
                                @error('ncol')
                                    <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mensaje alert alert-warning mb-4 text-center col-6 offset-3" role="alert">
                        {{ __('Haz clic en las sillas para desactivarlas.') }}
                    </div>

                    <div class="mostrarsillas d-flex justify-content-center mt-4 mb-4">
                        <table>
                            @for ($i = 1; $i <= $sala->n_filas; $i++)
                                <tr>
                                    @for ($j = 1; $j <= $sala->n_columnas; $j++)
                                        <td style="cursor: pointer" class="p-1">
                                            <?php
                                            $bandera = false;
                                            foreach ($ocupadas as $value) {
                                            if ($i == $value->n_fila && $j == $value->n_columna) {
                                            $bandera = true;
                                            }
                                            }
                                            ?>
                                            @if (!$bandera)
                                                <input style="display: none;" type="checkbox"
                                                    value="{{ $i }}-{{ $j }}" name='asientos[]'>
                                                <img src="{{ asset('imagenes/asientos/seat.png') }}" alt="Silla">
                                            @else
                                                <input style="display: none;" type="checkbox"
                                                    value="{{ $i }}-{{ $j }}" name='asientos[]' checked>
                                                <img style="display: none;" src="{{ asset('imagenes/asientos/seat.png') }}"
                                                    alt="Silla">
    
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        </table>
                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success text-white">{{ __('Actualizar') }}</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(() => {
            $(".tablero input").on("change", cargartablero);
            $("#creartablero").prop("disabled", true);
            $('td').css('cursor', 'pointer'); // 'default' to revert
            $('td').on("click", esconder);

        })

        function cargartablero() {
            $(".mostrarsillas").empty();
            if (($("#nrow").val() != "" && $("#nrow").val() != "0") && ($("#ncol").val() != "" && $("#ncol").val() !=
                "0")) {
                let tabla = "<table>";
                for (let i = 1; i <= $("#nrow").val(); i++) {
                    tabla += "<tr>";
                    for (let j = 1; j <= $("#ncol").val(); j++) {
                        tabla +=
                            "<td style='cursor: pointer' class='p-1'><input style='display: none;' type='checkbox' value='" +
                            i + "-" + j +
                            "' name='asientos[]'><img src='{{ asset('/imagenes/asientos/seat.png') }}'</td>";
                    }
                    tabla += "</tr>";
                }
                tabla += "<table>";

                $(".mostrarsillas").append(tabla);
                $('td').on("click", esconder);

                $("#creartablero").prop("disabled", false);

            } else {
                $("#creartablero").prop("disabled", true);
            }
        }

        function esconder() {
            if ($(this).find("img").is(':visible')) {
                $(this).find("img").hide()
                $(this).find("input").prop('checked', true);
            } else {
                $(this).find("img").show()
                $(this).find("input").prop('checked', false);
            }

        }

    </script>
@endsection
