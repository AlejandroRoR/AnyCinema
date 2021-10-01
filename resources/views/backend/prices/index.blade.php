@extends('backend.layouts.app')

@section('title')
    {{ __('Planes de Pago') }}
@endsection

@section('page-head')
    {{ __('Planes de Pago') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('matrix/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
<!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.prices.create') }}" class="btn btn-success text-white mb-4">{{ __('Crear Plan de Pago') }}</a>
                    <div class="alert alert-warning mb-4" role="alert">
                        {{ __('Si no especifica el precio de todos los dias de la semana el precio por defecto sera de 5€.') }}
                    </div>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Nombre') }}</th>
                                    <th scope="col">{{ __('Precio') }}</th>
                                    <th scope="col">{{ __('L') }}</th>
                                    <th scope="col">{{ __('M') }}</th>
                                    <th scope="col">{{ __('X') }}</th>
                                    <th scope="col">{{ __('J') }}</th>
                                    <th scope="col">{{ __('V') }}</th>
                                    <th scope="col">{{ __('S') }}</th>
                                    <th scope="col">{{ __('D') }}</th>
                                    <th scope="col">{{ __('Fecha') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($precios as $precio)
                                    <tr>
                                        <td>{{ $precio->id }}</td>
                                        <td>{{ $precio->nombre }}</td>
                                        <td>{{ $precio->precio }} €</td>
                                        <td>{{ $precio->lunes == '1' ? 'Si' : 'No' }}</td>
                                        <td>{{ $precio->martes == '1' ? 'Si' : 'No' }}</td>
                                        <td>{{ $precio->miercoles == '1' ? 'Si' : 'No' }}</td>
                                        <td>{{ $precio->jueves == '1' ? 'Si' : 'No' }}</td>
                                        <td>{{ $precio->viernes == '1' ? 'Si' : 'No' }}</td>
                                        <td>{{ $precio->sabado == '1' ? 'Si' : 'No' }}</td>
                                        <td>{{ $precio->domingo == '1' ? 'Si' : 'No' }}</td>
                                        <td>{{ $precio->fecha != "" ? $precio->fecha : '-' }}</td>
                                        <td>
                                            <form action="{{ route('admin.prices.destroy', $precio->id) }}" class="form-borrar" method="POST">
                                                @csrf
                                                @method('delete')
                                            </form>
                                            <a href="{{ route('admin.prices.show', $precio->id) }}" class='editar btn btn-info'><i class='fas fa-eye'></i></a>
                                            <a href="{{ route('admin.prices.edit', $precio->id) }}" class='editar btn btn-primary'><i class='fas fa-edit'></i></a>
                                            <button class="borrar-registro btn btn-danger text-white"><i
                                                class='fas fa-trash'></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
@endsection

@section('script')
<script src="{{ asset('matrix/assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('matrix/assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('matrix/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(() => {

            $('.borrar-registro').on("click", borrar);

            @if (App::getLocale() == 'es')
                $('#datatable').DataTable({
                language: {
                url: '{{ asset('js/datatable-lang/es.json') }}'
                }
                });
            @else
                $('#datatable').DataTable();
            @endif

        })

        function borrar() {
            Swal.fire({
                title: '{{ __('¿Estas seguro?') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28B779',
                cancelButtonColor: '#DA542E',
                confirmButtonText: '{{ __('Si') }}',
                cancelButtonText: '{{ __('No') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent().find('.form-borrar').submit();
                }
            })
        }

    </script>

@endsection