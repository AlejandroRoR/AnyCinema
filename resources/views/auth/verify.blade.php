
@if (Auth::user()->email_verified_at !== NULL)
<script>
    window.location.href = "{{ route('home') }}";
</script>
@endif

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
                <h1>{{ __('Verifica tu Email') }}</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<section class="login_box_area mt-5 mb-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header peli-head">
                    <h4 class="text-white">{{ __('Verifique su dirección de correo electrónico') }}</h4>
                    </div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                        </div>
                    @endif

                    {{ __('Antes de continuar, verifique su correo electrónico para ver si hay un enlace de verificación.') }}
                    {{ __('Si no recibió el correo electrónico') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('haga clic aquí para solicitar otro.') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@endsection
