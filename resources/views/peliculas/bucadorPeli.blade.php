@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/cartelera.css') }}">
@endsection

@section('content')

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>{{ __('Buscador') }}</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!-- Start category Area -->
    <section class="category-area">
        <div class="container">
            <div class="row mt-5 mb-5">

                <div class="buscador col-5 offset-7 mb-4">
                    <form action="{{ route('buscar.sesion') }}" method="POST">
                        @csrf
                        <div class="d-flex">
                            <input type="date" name="fecha" class="form-control">
                            
                            <button type="submit" class="btn btn-outline-warning ml-1"><i
                                    class="fas fa-search"></i></button>
                        </div>
                        @error('fecha')
                            <small class="text-danger w-100">* {{ $message }}</small>
                        @enderror
                    </form>
                </div>
                <div class="col-xl-9 col-lg-8 col-md-7">
                    @if (empty($pelis))
                        <div class="peli-head p-2 w-100 rounded">
                            <h3 class="text-white ml-4 mt-2">{{ __('Lo sentimos. No hay sesiones para este día.') }}</h3>
                        </div>
                    @endif
                    <?php $generos = []; ?>
                    @foreach ($pelis as $key => $peli)
                        <div class="peliculas-dia col-12">
                            <div class="peli-head p-2 w-100 rounded shadow">
                                @if (App::isLocale('es'))
                                    <h3 class="text-white ml-4 mt-2">
                                        {{ explode('-', $key)[2] . '-' . explode('-', $key)[1] . '-' . explode('-', $key)[0] }}
                                    </h3>
                                @else
                                    <h3 class="text-white ml-4 mt-2">{{ $key }}</h3>
                                @endif

                            </div>
                            <div class="listar-peliculas mt-3 mb-5">
                                {{-- {{$peli}} --}}

                                @foreach ($peli as $k => $val)
                                    <div class="pelicula rounded
                                        @foreach ($val[0]['genres'] as $gen) {{ $gen['id'] }} @endforeach">
                                        <a href="{{ route('buy.sesion', $k) }}">
                                            <img src="https://image.tmdb.org/t/p/w500/{{ $val[0]['poster_path'] }}"
                                                class="w-100" alt="Pelicula">
                                        </a>
                                        <h3>{{ $val[1] }}</h3>
                                    </div>

                                    <?php 
                                    foreach ($val[0]['genres'] as $gen) {
                                        if (!array_key_exists($gen['id'], $generos)) {
                                            $generos[$gen['id']] = $gen['name'];
                                        }
                                    } 
                                    ?>

                                @endforeach

                            </div>
                        </div>


                    @endforeach
                </div>
                <div class="col-xl-3 col-lg-4 col-md-5">
                    <div class="sidebar-categories shadow">
                        <div class="head peli-head">{{ __('Categorias') }}</div>
                        <ul class="main-categories">
                            @foreach ($generos as $key => $gen)
                                <li class="main-nav-list child filtro"><p href="#"
                                        id="{{ $key }}">{{ $gen }}</p></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End category Area -->
@endsection


@section('javascript')
    <script>
        $(() => {
            $('#botoncrear').prop('disabled', true);
            $('.filtro').css('cursor', 'pointer'); // 'default' to revert
            $('.filtro').on("click", aplicarFiltro);
        })

        function aplicarFiltro() {
            $('.pelicula').hide();
            $('.pelicula').parent().parent().hide();
            if ($(this).hasClass('filtroactivo')) {
                $(this).removeClass('filtroactivo');
                $('.pelicula').show();
                $('.pelicula').parent().parent().show();

            } else {
                $('.filtro').removeClass('filtroactivo')
                $(this).addClass('filtroactivo');
                
            }
            console.log($(this).find('p').attr('id'));
            $('.'+$(this).find('p').attr('id')).show();
            $('.'+$(this).find('p').attr('id')).parent().parent().show();
        }

    </script>

@endsection
