@extends('layouts.app')

@section('content')

    <section class="login_box_area section_gap mt-5">
        <div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<img class="img-fluid" src="{{asset('imagenes/login/login.jpg')}}" alt="">
						<div class="hover">
							<h4>{{ __('¿Eres nuevo?') }}</h4>
							<p>{{ __('Aquí podras comprar entradas y valorar nuestras peliculas.') }}</p>
							<a class="primary-btn" href="{{ route('register') }}">{{ __('Create una cuenta') }}</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>{{ __('Acceder') }}</h3>
						<form class="row login_form" action="{{ route('login') }}" method="POST" >
                            @csrf
							<div class="col-md-12 form-group">
								<input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{__('Correo electrónico')}}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{__('Correo electrónico')}}'">
                                @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Contraseña') }}" required onfocus="this.placeholder = ''" onblur="this.placeholder = '{{__('Contraseña')}}'">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        
                                    <label class="form-check-label" for="remember">{{ __('Recuérdame') }}</label>
								</div>
							</div>
							<div class="col-md-12 form-group">
                                <button type="submit" class="primary-btn">
                                    {{ __('Acceder') }}
                                </button>
                                <label class="form-check-label" for="remember">
                                    
                                </label>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('¿Olvidaste tu contraseña?') }}</a>
                                @endif
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
        
    </section>


@endsection
