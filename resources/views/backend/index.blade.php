@extends('backend.layouts.app')

@section('title', 'ADMIN')
@section('page-head', 'Dashboard')

@section('content')

    <!-- ============================================================== -->
    <!-- Sales Cards  -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover">
                <a href="{{ route('admin.prices') }}">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-currency-eur"></i></h1>
                        <h6 class="text-white">{{ __('Planes de Pago') }}</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover">
                <a href="{{ route('admin.users') }}">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-account-multiple"></i></h1>
                        <h6 class="text-white">{{ __('Usuarios') }}</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover">
                <a href="{{ route('admin.sales') }}">
                    <div class="box bg-warning text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-cash-multiple"></i></h1>
                        <h6 class="text-white">{{ __('Ventas') }}</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover">
                <a href="{{ route('admin.ratings') }}">
                    <div class="box bg-danger text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-star-circle"></i></h1>
                        <h6 class="text-white">{{ __('Valoraciones') }}</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- column -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Últimas Valoraciones') }}</h4>
                </div>
                <div class="comment-widgets scrollable">
                    @if (sizeof($valoraciones))
                        @foreach ($valoraciones as $val)
                            <!-- Comment Row -->
                            <div class="d-flex flex-row comment-row">
                                <div class="p-2"><img src="{{ asset('uploads/avatars/' . $val->img) }}" alt="user"
                                    class="rounded-circle usuarios-img"></div>
                                <div class="comment-text w-100">
                                    <h6 class="font-medium">{{ $val->name }}</h6>
                                    <span class="mb-3 d-block">{{ $val->comentario }}</span>
                                    <div class="comment-footer">
                                        <span class="text-muted float-end">{{ explode(' ', $val->created_at)[0] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @else
                        <h6 class="font-medium text-center text-danger">No hay ninguna valoración</h6>
                    @endif

                </div>
            </div>
        </div>
        <!-- column -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Últimos Usuarios') }}</h4>
                </div>
                <div class="comment-widgets scrollable">
                    @if (sizeof($usuarios))

                        @foreach ($usuarios as $user)
                            <!-- Comment Row -->
                            <div class="d-flex flex-row comment-row">
                                <div class="p-2"><img src="{{ asset('uploads/avatars/' . $user->img) }}" alt="user"
                                        class="rounded-circle usuarios-img"></div>
                                <div class="comment-text w-100">
                                    <h6 class="font-medium">{{ $user->name }}</h6>
                                    <span class="mb-3 d-block">{{ $user->email }} </span>
                                    <div class="comment-footer">
                                        <span class="text-muted float-end">{{ explode(' ', $user->created_at)[0] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @else
                        <h6 class="font-medium text-center text-danger">No hay ninguna valoración</h6>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->

@endsection
