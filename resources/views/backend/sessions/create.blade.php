@extends('backend.layouts.app')

@section('title')
    {{ __('Sesiones') }}
@endsection

@section('page-head')
    {{ __('Sesiones') }}
@endsection

@section('content')
    <div class="col-md-12">
        <a href="{{ route('admin.sessions') }}" class="btn btn-info mb-3">{{ __('Volver') }}</a>
        <div class="card">
            <form action="{{ route('admin.sessions.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <h4 class="card-title">{{ __('Crear Sesión') }}</h4>
                    <hr>
                    @if (count($salas) == 0 || count($carteleras) == 0)
                        <div class="alert alert-warning text-center col-6 offset-3" role="alert">
                            <p>{{ __('Para crear sesiones hace falta una sala de cine y una cartelera.') }}</p>
                        </div>
                    @else

                        <div class="form-group row">
                            <label for="fname"
                                class="col-sm-4 text-end control-label col-form-label">{{ __('Cartelera') }}</label>
                            <div class="col-sm-4">
                                <select name="idcart" id="carteleraid" class="form-select cartelera">
                                    <option>{{ __('Selecciona una cartelera') }}</option>
                                    @foreach ($carteleras as $cart)
                                        <option value="{{ $cart->id }}">
                                            {{ __('Cartelera de ') . $cart->fecha_inicio . __(' a ') . $cart->fecha_fin }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idcart')
                                    <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname"
                                class="col-sm-4 text-end control-label col-form-label">{{ __('Pelicula') }}</label>
                            <div class="col-sm-4">
                                <select name="idpeli" id="peliscargar" class="form-select">
                                    <option>{{ __('Selecciona una pelicula') }}</option>
                                </select>
                                @error('idpeli')
                                    <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname"
                                class="col-sm-4 text-end control-label col-form-label">{{ __('Sala') }}</label>
                            <div class="col-sm-4">
                                <select name="idsala" class="form-select">
                                    <option>{{ __('Selecciona una sala') }}</option>
                                    @foreach ($salas as $sala)
                                        <option value="{{ $sala->id }}">{{ $sala->n_sala }}</option>
                                    @endforeach
                                </select>
                                @error('idsala')
                                    <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname"
                                class="col-sm-4 text-end control-label col-form-label">{{ __('Fecha') }}</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="fecha" placeholder="dd/mm/yyyy"
                                    value="{{ old('fecha') }}">
                                @error('fecha')
                                    <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname"
                                class="col-sm-4 text-end control-label col-form-label">{{ __('Hora') }}</label>
                            <div class="col-sm-4">
                                <input type="time" class="form-control" name="hora" value="{{ old('hora') }}">
                                @error('hora')
                                    <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>
                        </div>


                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" id="botoncrear"
                                    class="btn btn-success text-white">{{ __('Crear Sesión') }}</button>
                            </div>
                        </div>

                    @endif
                </div>
            </form>
        </div>

    </div>

@endsection

@section('script')
<script src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $(() => {
            $('.cartelera').on("change", cargarPelis);
        })

        function cargarPelis() {
            $("#peliscargar").empty()
            $.ajax({
                    url: "{{ route('admin.sessions.cargarpelis') }}",
                    type: "POST",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'idcartelera': $("#carteleraid").find(":selected").val()
                    }
                })
                .done((response) => {
                    //mostrar en la tabla
                    console.log("DATOS BIEN");
                    $("#peliscargar").append('<option>{{ __('Selecciona una pelicula') }}</option>')
                    $.each(response,(ind, ele) => {
                        console.log(ind+ " - " +ele);
                        $("#peliscargar").append('<option value="'+ind+'">'+ele+'</option>')
                    })
                })
                .fail(function(response, textStatus, errorThrown) {
                    console.log(response);
                })

        }

        function swalError(icono, titulo, texto) {
            Swal.fire({
                position: 'top-end',
                icon: icono,
                timer: 1000,
                showConfirmButton: false,
                title: titulo,
                text: texto
            });
        }
    </script>
<script src="{{ asset('js/conexionAJAX.js') }}"></script>
@endsection
