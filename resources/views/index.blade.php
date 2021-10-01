@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <!-- start banner Area -->
    <section class="banner-area">
        <div class="container">
            <div class="row fullscreen align-items-center justify-content-start mt-5">
                <div class="col-12">
                    <div class="active-banner-slider owl-carousel">

                        @foreach ($carousel as $img)
                            <!-- single-slide -->
                            <div class="row single-slide">
                                <div class="col-lg-12">
                                    <div class="banner-img">
                                        <a href="{{ route('pelicula.detallada', $img[1]) }}">
                                        <img class="img-fluid m-auto carousel-img"
                                            src="https://image.tmdb.org/t/p/w500/{{ $img[0] }}"></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->



    <!-- Start category Area -->
    <section class="category-area mt-5 mb-5">
        <div class="container">
            <div class="col-12">

                @foreach ($pelis as $key => $value)
                    <div class="card mt-4">
                        <div class="card-header titulo-peli">
                            <h4><a href="{{ route('pelicula.detallada', $key) }}">{{ $value[0]['title'] }}</a></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <a href="{{ route('pelicula.detallada', $key) }}"><img class="img-fluid"
                                        src="https://image.tmdb.org/t/p/w500/{{ $value[0]['poster_path'] }}" alt="foto"></a>
                                </div>
                                <div class="col-lg-10 col-md-6 col-sm-12 mt-sm-5">
                                    <p class="card-text text-justify">{{ $value[0]['overview'] }}</p>

                                    <h5 class="card-title mt-5">{{ __('Sesiones de Hoy') }}</h5>
                                    <div class="sesiones row ml-2">
                                        @if (sizeof($value[1]))
                                            @foreach ($value[1] as $sesion)
                                                <a href="{{ route('buy.sesion', $sesion->id) }}" class="genric-btn success-border ml-2 mr-2">{{ explode(":",$sesion->hora)[0].':'.explode(":",$sesion->hora)[1] }}</a>
                                            @endforeach
                                        @else
                                            <p class="sesiones-agotadas">{{ __('Sesiones Agotadas') }}</p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <a href="{{ route('cartelera') }}" class="genric-btn primary-border mt-4 w-100">{{ __('Ver Más') }}</a>


            </div>
        </div>
    </section>
    <!-- End category Area -->

@endsection
