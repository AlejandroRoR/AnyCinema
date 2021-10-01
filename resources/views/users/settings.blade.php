@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
@endsection

@section('content')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>{{ __('Perfil de Usuario') }}</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
    <section class="category-area mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-12">
                    <form action="{{ route('users.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="card shadow">
                            <div class="card-header titulo-historial">
                                <h3 class="card-title">{{ __('Configuración de Usuario') }}</h3>
                            </div>

                            <div class="card-body p-5">
                                <div class="row">
                                    <div class="imagen col-2">
                                        <img src="{{ asset('/uploads/avatars/' . $usuario->img) }}" alt="img-avatar"
                                            class="border rounded-circle" style="width:150px; height:150px;">
                                    </div>
                                    <div class="col-8 ml-4 mt-4">
                                        <h1>{{ $usuario->name }}</h1>

                                        <label>{{ __('Actualizar Imagen de Perfil') }}</label><br>
                                        <input type="file" name="avatar" class="form-control-file">
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>{{ __('Nombre') }}</label>
                                            <input type="text" class="form-control" value="{{ $usuario->name }}"
                                                name="name">
                                            @error('name')
                                                <p class="text-danger">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Email</label>
                                            <input type="text" class="form-control" value="{{ $usuario->email }}"
                                                name="correo">
                                            @error('correo')
                                                <p class="text-danger">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-5">
                                    <button type="submit" class="genric-btn primary rounded">{{ __('Guardar') }}</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="col-12 mt-5">
                    <form action="{{ route('users.cambiarcontra', $usuario->id) }}" method="POST" autocomplete="off"
                        class="form-horizontal">
                        @csrf
                        @method('put')

                        <div class="card shadow">
                            <div class="card-header titulo-historial">
                                <h3 class="card-title">{{ __('Cambiar Contraseña') }}</h3>
                            </div>
                            <div class="card-body p-5">

                                <div class="col-8 offset-2 form-group">
                                    <label>{{ __('Contraseña Actual') }}</label>
                                    <input type="password" class="form-control" name="old_password">

                                    @error('old_password')
                                        <p class="text-danger">* {{ $message }}</p>
                                    @enderror

                                    @if (Session::has('errorPass1'))
                                        <div>
                                            <p class="text-danger">* {{ session('errorPass1') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-8 offset-2 form-group">
                                    <label>{{ __('Nueva Contraseña') }}</label>
                                    <input type="password" class="form-control" name="password">

                                    @error('password')
                                        <p class="text-danger">* {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-8 offset-2 form-group">
                                    <div class="form-group">
                                        <label>{{ __('Confirmar Nueva Contraseña') }}</label>
                                        <input type="password" class="form-control" name="password_new">

                                        @error('password_new')
                                            <p class="text-danger">* {{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>

                                @if (Session::has('errorPass2'))
                                    <div>
                                        <p class="text-danger">* {{ session('errorPass2') }}</p>
                                    </div>
                                @endif

                                <div class="text-center mt-5">
                                    <button type="submit"
                                        class="genric-btn primary rounded">{{ __('Cambiar Contraseña') }}</button>
                                </div>
                            </div>


                        </div>

                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
