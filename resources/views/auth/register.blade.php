@extends('layouts.app')

@section('content')
<section class="login_box_area section_gap mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="{{asset('imagenes/login/login.jpg')}}" alt="">
                    <div class="hover">
                        <h4>{{ __('¿Ya estas registrado?') }}</h4>
                        <p>{{ __('Aquí podras comprar entradas y valorar nuestras peliculas.') }}</p>
                        <a class="primary-btn" href="{{ route('login') }}">{{ __('Acceder') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="register_form_inner">
                    <h3>{{ __('Registrarse') }}</h3>
                    <form class="row login_form" action="{{ route('register') }}" method="POST" >
                        @csrf
                        
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Correo electrónico') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ __('Correo electrónico') }}'">
                            @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="{{ __('Nombre de usuario') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ __('Nombre de usuario') }}'">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Contraseña') }}" required onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ __('Contraseña') }}'">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="{{ __('Confirmar contraseña') }}" required onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ __('Confirmar contraseña') }}'">
                        </div>
                        
                        <div class="col-md-12 form-group mt-5">
                            <button type="submit" class="primary-btn">
                                {{ __('Registrarse') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</section>
@endsection
