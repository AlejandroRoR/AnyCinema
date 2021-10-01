@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
    <link rel="stylesheet" href="{{ asset('matrix/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>{{ __('Historial de compras') }}</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
    <section class="category-area mt-5 mb-5">
        <div class="container">
            <div class="card shadow">
                <div class="card-header titulo-historial">
                    <h3 class="card-title">{{ __('Historial de compras') }}</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead>
                                <tr>
                                    <td scope="col">#</td>
                                    <td scope="col">Pelicula</td>
                                    <td scope="col">Precio</td>
                                    <td scope="col">Fecha</td>
                                    <td scope="col"></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ $pelis[$venta->id] }}</td>
                                        <td>{{ $venta->precio }} €</td>
                                        <td>{{ $venta->created_at }}</td>
                                        <td>
                                            @if ($venta->cancelado == 0)
                                            <a href="{{ route('descargar.entradas', $venta->id) }}"
                                                class='btn btn-success text-white'>{{ __('Descargar Entradas') }}</a>
                                                <a href="{{ route('paypal.cancel', $venta->id) }}"
                                                    class='btn btn-danger text-white'>{{ __('Cancelar Pago') }}</a>
                                                
                                            @else
                                                <p class="text-success"><i class="fas fa-check"></i> {{ __('Pago devuelto') }}</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection


@section('javascript')
    <script src="{{ asset('matrix/assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('matrix/assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('matrix/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    <script>
        $(() => {

            @if (App::getLocale() == 'es')
                $('#datatable').DataTable({
                "order": [[ 3, "desc" ]],
            
                language: {
                url: '{{ asset('js/datatable-lang/es.json') }}'
                }
                });
            @else
                $('#datatable').DataTable({
                "order": [[ 3, "desc" ]]
                });
            @endif
            /* $('#datatable_next').find('a').text('>');
            $('#datatable_previous').find('a').text('<'); */
        })

    </script>

@endsection
