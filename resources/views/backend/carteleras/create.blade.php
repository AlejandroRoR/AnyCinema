@extends('backend.layouts.app')

@section('title')
    {{ __('Carteleras') }}
@endsection

@section('page-head')
    {{ __('Carteleras') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('js/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pelis.css') }}">
@endsection

@section('content')

    <div class="col-md-12">
        <a href="{{ route('admin.carteleras') }}" class="btn btn-info mb-4">{{ __('Volver') }}</a>
        <div class="card">
            <form action="{{ route('admin.carteleras.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <h4 class="card-title">{{ __('Crear Cartelera') }}</h4>
                    <hr>
                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Fecha Inicio') }}</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="fini" placeholder="dd/mm/yyyy"
                                value="{{ old('fini') }}">
                            @error('fini')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Fecha Fin') }}</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="ffin" placeholder="dd/mm/yyyy"
                                value="{{ old('ffin') }}">
                            @error('ffin')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center my-4">
                        @if (session('errorFecha'))
                            <small class="text-danger mb-4">{{ session('errorFecha') }}</small>
                        @endif
                    </div>

                    <div class="text-center">

                        <div class="alert alert-warning mb-4 col-4 offset-4" role="alert">
                            {{ __('Seleccione un minimo de 7 películas por cartelera.') }}
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-3" id="abrir" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> {{ __('Añadir Películas') }}
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            {{ __('Selecciona las películas') }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="buscador">
                                            <div class="d-flex">
                                                <input class="form-control mr-sm-2 inbuscar" placeholder="Search">
                                                <p class="btn btn-outline-success my-2 my-sm-0 buscar"><i
                                                        class="fas fa-search"></i></p>
                                                <p class="btn btn-outline-success my-2 my-sm-0 resetbuscar ms-2"><i class="fas fa-sync-alt"></i></i></button>
                                            </div>
                                        </div>
                                        <!-- Vertically centered scrollable modal -->

                                        <div class="row peliculas">

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"
                                            data-bs-dismiss="modal">{{ __('Aceptar') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="escondidos">

                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" id="botoncrear"
                                class="btn btn-success text-white">{{ __('Crear Cartelera') }}</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let nomPelis = [];

        $(() => {
            $('#botoncrear').prop('disabled', true);
            $('#abrir').on("click", insertaPelis);
            $('.resetbuscar').on("click", function(){
                $('.inbuscar').val("");
                insertaPelis();
            });
            $('.buscar').on("click", buscarPeli);
        })

        function insertaPelis() {
            $.ajax({
                    url: "{{ route('admin.carteleras.popular') }}",
                    type: "GET",
                    dataType: "json"
                })
                .done((response) => {
                    //mostrar en la tabla
                    if ($(response.results).length != 0) {
                        $(".peliculas").empty();
                        $(response.results).each((ind, ele) => {
                            if ($(`.escondidos input[value='${ele.id}']`).length > 0) {
                                if(ele.poster_path === null){
                                    $(".peliculas").append(
                                    `<div class="col-3 mt-4 peli selected"><img class="img-fluid" id="${ele.id}" src="{{ asset('imagenes/peliculas/pelidefault.jpg') }}"><h5 id="${ele.id}" class="text-center">${ele.title}</h5></div>`
                                    );
                                } else{
                                    $(".peliculas").append(
                                    `<div class="col-3 mt-4 peli selected"><img class="img-fluid" id="${ele.id}" src="https://image.tmdb.org/t/p/w500/${ele.poster_path}"><h5 id="${ele.id}" class="text-center">${ele.title}</h5></div>`
                                    );
                                }
                            } else {
                                if(ele.poster_path === null){
                                    $(".peliculas").append(
                                    `<div class="col-3 mt-4 peli"><img class="img-fluid" id="${ele.id}" src="{{ asset('imagenes/peliculas/pelidefault.jpg') }}"><h5 id="${ele.id}" class="text-center">${ele.title}</h5></div>`
                                    );
                                } else{
                                    $(".peliculas").append(
                                    `<div class="col-3 mt-4 peli"><img class="img-fluid" id="${ele.id}" src="https://image.tmdb.org/t/p/w500/${ele.poster_path}"><h5 id="${ele.id}" class="text-center">${ele.title}</h5></div>`
                                    );
                                }
                            }
                        })
                    } else {
                        $(".peliculas").empty();
                        $(".peliculas").append(
                                    `<div class="col-12 mt-4"><h5 class="text-center">No se ha encontrado la pelicula</h5></div>`);                    }
                    $('.peli img').css('cursor', 'pointer');
                    $('.peli img').on('click', addPeli);
                })
                .fail(function(response, textStatus, errorThrown) {
                    swalError("error", textStatus, errorThrown)
                })

        }

        function buscarPeli() {
            let ruta = "{{ route('admin.carteleras.search') }}";
            $.ajax({
                    url: ruta,
                    type: "POST",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'busqueda': $('.inbuscar').val()
                    }
                })
                .done((response) => {
                    if ($(response.results).length != 0) {
                        $(".peliculas").empty();
                        $(response.results).each((ind, ele) => {
                            
                            if ($(`.escondidos input[value='${ele.id}']`).length > 0) {
                                if(ele.poster_path === null){
                                    $(".peliculas").append(
                                    `<div class="col-3 mt-4 peli selected"><img class="img-fluid" id="${ele.id}" src="{{ asset('imagenes/peliculas/pelidefault.jpg') }}"><h5 id="${ele.id}" class="text-center">${ele.title}</h5></div>`
                                    );
                                } else{
                                    $(".peliculas").append(
                                    `<div class="col-3 mt-4 peli selected"><img class="img-fluid" id="${ele.id}" src="https://image.tmdb.org/t/p/w500/${ele.poster_path}"><h5 id="${ele.id}" class="text-center">${ele.title}</h5></div>`
                                    );
                                }
                            } else {
                                if(ele.poster_path === null){
                                    $(".peliculas").append(
                                    `<div class="col-3 mt-4 peli"><img class="img-fluid" id="${ele.id}" src="{{ asset('imagenes/peliculas/pelidefault.jpg') }}"><h5 id="${ele.id}" class="text-center">${ele.title}</h5></div>`
                                    );
                                } else{
                                    $(".peliculas").append(
                                    `<div class="col-3 mt-4 peli"><img class="img-fluid" id="${ele.id}" src="https://image.tmdb.org/t/p/w500/${ele.poster_path}"><h5 id="${ele.id}" class="text-center">${ele.title}</h5></div>`
                                    );
                                }
                                
                            }
                        })
                    } else {
                        $(".peliculas").empty();
                        $(".peliculas").append(
                                    `<div class="col-12 mt-4"><h5 class="text-center">No se ha encontrado la pelicula</h5></div>`);
                    }
                    $('.peli img').css('cursor', 'pointer');
                    $('.peli img').on('click', addPeli);
                })
                .fail(function(response, textStatus, errorThrown) {
                    swalError("error", textStatus, errorThrown)
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

        function addPeli() {
            if ($(this).parent().hasClass('selected')) {
                $(this).parent().removeClass("selected");
                $(`.escondidos input[value='${$(this).attr("id")}']`).remove();
            } else {
                $(this).parent().addClass("selected");
                $(".escondidos").append(`<input type="hidden" name="peliculas[]" value="${$(this).attr("id")}">`);
            }
            if ($('.escondidos').children().length > 6) {
                $('#botoncrear').prop('disabled', false);
            } else {
                $('#botoncrear').prop('disabled', true);
            }
        }

    </script>
    <script src="{{ asset('js/conexionAJAX.js') }}"></script>
@endsection
