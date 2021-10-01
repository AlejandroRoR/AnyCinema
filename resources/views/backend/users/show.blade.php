@extends('backend.layouts.app')

@section('title')
    {{ __('Usuarios') }}
@endsection

@section('page-head')
    {{ __('Usuarios') }}
@endsection

@section('content')

    <div class="botones d-flex">
        <a href="{{ route('admin.users') }}" class="btn btn-info">{{ __('Volver') }}</a>
        <a href="{{ route('admin.users.edit', $usuario->id) }}" class='editar btn btn-primary ms-2'><i
                class='fas fa-edit'></i> {{ __('Editar') }}</a>
    </div>
    <div class="col-10 offset-1">


        <div class="mostrar mt-4">
            <ul class="list-group">
                <li class="list-group-item text-center"><b><img src="{{ asset('/uploads/avatars/' . $usuario->img) }}"
                            alt="img-avatar" class="border" style="width:150px; height:150px; border-radius:50%"></li>
                <li class="list-group-item"><b>ID - </b>{{ $usuario->id }}</li>
                <li class="list-group-item"><b>{{ __('CORREO') }} - </b>{{ $usuario->email }}</li>
                <li class="list-group-item"><b>{{ __('NOMBRE') }} - </b>{{ $usuario->name }}</li>
                <li class="list-group-item"><b>{{ __('TIPO DE CUENTA') }} - </b>{{ $usuario->rol }}</li>
                <li class="list-group-item"><b>{{ __('VERIFICADO') }} - </b><?= $usuario->email_verified_at != null ? 'Si' : 'No' ?></li>
                        <li class="list-group-item"><b>{{ __('CREADA') }} - </b>{{ $usuario->created_at }}</li>
                        <li class="list-group-item"><b>{{ __('ACTUALIZADA') }} - </b>{{ $usuario->updated_at }}</li>
                      </ul>
                </div>
            </div>
            
@endsection
