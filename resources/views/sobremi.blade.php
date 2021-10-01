@extends('layouts.app')


@section('content')

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>{{ __('Sobre Mi') }}</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Sobremi Area =================-->
    <section class="cart_area {{-- section_gap mt-5 --}}">
        <div class="container">
            <div class="comment-form">
                <h4>{{ __('Sobre Mi') }}</h4>
                <div class="row">
                    <div class="col-6">
                        <h3>Alejandro Rodríguez Romero</h3>
                        <p>{{ __('Alumno del IES Trassierra y creador del proyecto AnyCinema.') }}</p>
                        <p>{{ __('Este proyecto está enfocado en la gestión de un cine que se puede adaptar a cualquier sala de cine.') }}</p>
                    </div>
                    <div class="col-6">
                        <h3>I.E.S. TRASSIERRA</h3>
                        <img src="{{ asset('imagenes/sobremi/logo trassierra.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Sobremi Area =================-->
    
@endsection
