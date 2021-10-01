<!DOCTYPE html>
<html lang="es-ES" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>AnyCinema</title>
    @yield('css')

    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    
    <!--KARMA============================================= -->
    <link rel="stylesheet" href="{{ asset('karma/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('karma/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('karma/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('karma/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('karma/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('karma/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('karma/css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('karma/css/ion.rangeSlider.css') }}" />
    <link rel="stylesheet" href="{{ asset('karma/css/ion.rangeSlider.skinFlat.css') }}" />
    <link rel="stylesheet" href="{{ asset('karma/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('karma/css/main.css') }}">

</head>

<body>

    <!-- Start Header Area -->
    <header class="header_area sticky-header">
        <div class="main_menu">
            <nav class="navbar navbar-expand-lg navbar-light main_box">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <a class="navbar-brand logo_h mt-2 mb-2" href="{{ route('home') }}"><img
                            src="{{ asset('logo.png') }}" class="logo"> </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto">
                            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('home') }}">{{ __('Inicio') }}</a></li>
                            <li class="nav-item {{ request()->is('cartelera') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('cartelera') }}">{{ __('Cartelera') }}</a></li>
                            <li class="nav-item {{ request()->is('sobremi') ? 'active' : '' }}"><a class="nav-link"
                                        href="{{ route('sobremi') }}">{{ __('Sobre mi') }}</a></li>
                            <li class="nav-item">
                                <a href="{{ route('language', 'es') }}">
                                    <img src="{{ asset('imagenes/banderas/spain.png') }}" alt="banderita"
                                        class="img-fluid {{ App::getLocale() != 'es' ? 'idioma' : '' }}" width="40">
                                </a>
                                <a href="{{ route('language', 'en') }}">
                                    <img src="{{ asset('imagenes/banderas/english.png') }}" alt="banderita"
                                        class="img-fluid {{ App::getLocale() != 'en' ? 'idioma' : '' }}" width="40">
                                </a>
                            </li>


                        </ul>

                        <ul class="nav navbar-nav ml-5">

                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item"><a href="{{ route('login') }}"
                                            class="genric-btn primary-border circle arrow"><i
                                                class="fas fa-sign-in-alt mr-2"></i>{{ __('Acceder') }}</a></li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <img src="{{ asset('uploads/avatars/' . Auth::user()->img) }}"
                                            class="img-fluid d-md-none d-none d-sm-none d-lg-inline perfil-img">
                                        <p class="d-lg-none">{{ Auth::user()->name }}</p>
                                    </a>


                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @auth
                                            <a class="dropdown-item" href="{{ route('users.config') }}">{{ __('Perfil') }}</a>
                                            <a class="dropdown-item" href="{{ route('users.compras') }}">{{ __('Historial Compras') }}</a>
                                        @endauth

                                        <?php if (Auth::user()->rol == 'admin') { ?>
                                        <a class="dropdown-item" href="{{ route('backend') }}">{{ __('Administración') }}</a>
                                        <?php } ?>
                                        <hr class="mr-2 ml-2">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                                                 document.getElementById('logout-form').submit();">
                                            {{ __('Cerrar sesión') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

    </header>
    <!-- End Header Area -->

    @yield('content')

    <!-- start footer Area -->
    <footer class="footer-area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 offset-3">
                    <div class="single-footer-widget">
                        <h6>{{ __('Sobre Nosotros') }}</h6>
                        <p class="text-justify">
                            {{ __('Este es un proyecto del instituro IES Trassierra del alumno Alejandro Rodríguez Romero.') }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 offset-lg-0 offset-md-2 offset-sm-1">
                    <div class="single-footer-widget">
                        <h6>{{ __('Compañia') }}</h6>
                        <ul>
                            <li><a href="#">{{ __('Terminos y servicios') }}</a></li>
                            <li><a href="#">{{ __('Política de privacidad') }}</a></li>
                            <li><a href="#">{{ __('Política de devoluciones') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                    <div class="single-footer-widget">
                        <h6>{{ __('Síguenos') }}</h6>
                        <div class="footer-social d-flex align-items-center">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
                <p class="footer-text m-0">{{ __('Todos los derechos reservados a') }} Alejandro Rodríguez Romero. © 2021</p>
            </div>
        </div>
    </footer>
    <!-- End footer Area -->


    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>


    <!-- Karma -->
    <script src="{{ asset('karma/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="{{ asset('karma/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('karma/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('karma/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('karma/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('karma/js/nouislider.min.js') }}"></script>
    {{-- <script src="{{ asset('karma/js/countdown.js') }}"></script> --}}
    <script src="{{ asset('karma/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('karma/js/owl.carousel.min.js') }}"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="{{ asset('karma/js/gmaps.min.js') }}"></script>
    <script src="{{ asset('karma/js/main.js') }}"></script>

    @yield('javascript')

</body>

</html>
