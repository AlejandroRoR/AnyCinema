@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/pelidetail.css') }}">
@endsection

@section('content')
    <div class="product_image_area mt-5">
        <div class="container">
            <div class="row s_product_inner">
                <div class="col-lg-6">
                    <img class="img-fluid" src="https://image.tmdb.org/t/p/w500/{{ $pelicula['poster_path'] }}">
                </div>
                <div class="col-lg-6">
                    <div class="s_product_text">
                        <h3>{{ $pelicula['title'] }}</h3>
                        <hr>
                        <h2>{{ __('Géneros') }}</h2>
                        <ul class="list row mb-4">
                            @foreach ($pelicula['genres'] as $genero)
                                <li class="genero">{{ $genero['name'] }}</li>
                            @endforeach

                        </ul>
                        <p class="descripcion text-justify">{{ $pelicula['overview'] }}</p>
                        <div class="product_count col-12">
                            <h2>{{ __('Sesiones de Hoy') }}</h2>
                            <div class="sesiones">

                                @if (sizeof($sesiones))
                                    @foreach ($sesiones as $sesion)
                                        @if ($sesion->agotada == 0)
                                            <a href="{{ route('buy.sesion', $sesion->id) }}"
                                                class="genric-btn success-border ml-2 mr-2">{{ explode(':', $sesion->hora)[0] . ':' . explode(':', $sesion->hora)[1] }}</a>
                                        @else
                                            <a href="#"
                                                class="genric-btn danger-border ml-2 mr-2">{{ explode(':', $sesion->hora)[0] . ':' . explode(':', $sesion->hora)[1] }}
                                                - {{ __('Agotada') }}</a>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="sesiones-agotadas">{{ __('Sesiones Agotadas') }}</p>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <h3 class="mt-2">Reviews</h3>
            </ul>
            <div class="tab-content" id="myTabContent">

                <div class="fade show" id="review">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row total_rate">
                                <div class="col-12">
                                    <div class="box_total">
                                        <h5>Overall</h5>
                                        @if ($totalcoments > 0)
                                            <h4>{{ number_format($totalpuntos / $totalcoments, 1) }}</h4>
                                        @else
                                            <h4>0.0</h4>
                                        @endif
                                        <h6>({{ $totalcoments }} Reviews)</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="review_list mt-3">

                                @foreach ($valoraciones as $valor)
                                    <div class="review_item">
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="{{ asset('/uploads/avatars/' . $valor->img) }}"
                                                    class="imgcoment" alt="">
                                            </div>
                                            <div class="media-body puntuacion">
                                                <h4>{{ $valor->name }}</h4>
                                                <i class="fa fa-star {{ $valor->puntuacion >= 1 ? 'selectp' : '' }}"></i>
                                                <i class="fa fa-star {{ $valor->puntuacion >= 2 ? 'selectp' : '' }}"></i>
                                                <i class="fa fa-star {{ $valor->puntuacion >= 3 ? 'selectp' : '' }}"></i>
                                                <i class="fa fa-star {{ $valor->puntuacion >= 4 ? 'selectp' : '' }}"></i>
                                                <i class="fa fa-star {{ $valor->puntuacion == 5 ? 'selectp' : '' }}"></i>
                                            </div>
                                        </div>
                                        <p>{{ $valor->comentario }}</p>
                                    </div>
                                @endforeach



                            </div>
                        </div>

                        @if ($permitir)
                            <div class="col-lg-6">
                                <div class="review_box">
                                    <h4>{{ __('Añade una Valoración') }}</h4>
                                    <p>{{ __('Tu puntuación:') }}</p>
                                    <ul class="list puntuacion">
                                        <li id="1"><i class="fa fa-star"></i></li>
                                        <li id="2"><i class="fa fa-star"></i></li>
                                        <li id="3"><i class="fa fa-star"></i></li>
                                        <li id="4"><i class="fa fa-star"></i></li>
                                        <li id="5"><i class="fa fa-star"></i></li>
                                    </ul>
                                    <form class="row contact_form" action="{{ route('add.valoracion') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="peli" value="{{ $pelicula['id'] }}">
                                        <input type="hidden" name="puntuacion" id="puntos" value>
                                        @error('puntuacion')
                                            <small class="text-danger ml-4">* {{ $message }}</small>
                                        @enderror

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" name="coment" rows="1" placeholder="Review"
                                                    onfocus="this.placeholder = ''"
                                                    onblur="this.placeholder = 'Review'">{{ old('coment') }}</textarea>
                                                @error('coment')
                                                    <small class="text-danger">* {{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <button type="submit" value="submit"
                                                class="primary-btn">{{ __('Comentar') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Product Description Area =================-->

@endsection

@section('javascript')
    <script>
        $(() => {
            $('#botoncrear').prop('disabled', true);
            $('.puntuacion li').on("click", addvaloracion);
            $('.puntuacion li').css('cursor', 'pointer'); // 'default' to revert
        })

        // Funcion para calcular el valor de la valoración y pintar las estrellas
        function addvaloracion() {
            $(".puntuacion li").removeClass("selectp");
            let puntuacion = $(this).attr("id");
            for (let i = 1; i <= puntuacion; i++) {
                $(".puntuacion").find("#" + i).addClass("selectp");
            }
            $("#puntos").val(puntuacion);
        }

    </script>
@endsection
