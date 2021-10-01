@extends('backend.layouts.app')

@section('title')
    {{ __('Usuarios') }}
@endsection

@section('page-head')
    {{ __('Usuarios') }}
@endsection

@section('content')

    <div class="col-md-12">
        <a href="{{ route('admin.users') }}" class="btn btn-info mb-4">{{ __('Volver') }}</a>
        <div class="card">
            <form action="{{ route('admin.users.update', $usuario) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card-body">
                    <h4 class="card-title">{{ __('Editar Usuario') }}</h4>
                    <hr>

                    <div class="form-group row align-items-center">
                        <div class="col-sm-4 text-end">
                            <img src="{{ asset('/uploads/avatars/'.$usuario->img)}}" class="border" alt="img-avatar"
                                    style="width:130px; height:130px; border-radius:50%">
                        </div>
                        <div class="col-sm-4 h-100">
                            <div>
                                <input type="file" class="form-control" name="avatar" value="{{ old('avatar') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Correo Electrónico') }}</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="correo" value="{{ old('correo', $usuario->email) }}">
                            @error('correo')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname"
                            class="col-sm-4 text-end control-label col-form-label">{{ __('Nombre de Usuario') }}</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="name" value="{{ old('name', $usuario->name) }}">
                            @error('name')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cono1" class="col-sm-4 text-end control-label col-form-label">Rol</label>
                        <div class="col-sm-4">
                            <select name="tipo" class="form-select">
                                <option value="user" {{ $usuario->rol == 'user' ? 'selected' : '' }}>{{ __('Usuario') }}</option>
                                <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>{{ __('Administrador') }}</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="border-top">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success text-white">{{ __('Actualizar') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
