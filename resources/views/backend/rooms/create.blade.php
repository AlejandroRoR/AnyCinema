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
            <form action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <h4 class="card-title">{{ __('Crear Sala') }}</h4>
                    <hr>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Nº de Sala') }}</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ old('nsala') }}" name="nsala">
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
                                <input type="text" class="form-control" id="nrow" value="{{ old('nrow') }}" name="nrow">
                                @error('nrow')
                                    <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname"
                                class="col-sm-4 text-end control-label col-form-label">{{ __('Nº de Butacas') }}</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="ncol" value="" name="ncol">
                                @error('ncol')
                                    <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mensaje alert alert-warning mb-4 text-center col-6 offset-3" role="alert">
                        {{ __('Haz clic en las sillas para desactivarlas.') }}
                    </div>

                    <div class="mostrarsillas d-flex justify-content-center mb-3">

                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" id="creartablero"
                                class="btn btn-success text-white">{{ __('Crear Sala') }}</button>
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
            $(".mensaje").hide();
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
                $(".mensaje").show();
            } else {
                $("#creartablero").prop("disabled", true);
                $(".mensaje").hide();
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
