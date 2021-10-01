@extends('backend.layouts.app')

@section('title')
    {{ __('Ventas') }}
@endsection

@section('page-head')
    {{ __('Ventas') }}
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
                    {{-- <div class="botones">
                    <a href="{{ route('admin.sales.create') }}" class="btn btn-success">Crear Venta</a>
                    </div> --}}
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Usuario') }}</th>
                                    <th scope="col">{{ __('Pelicula') }}</th>
                                    <th scope="col">{{ __('Precio') }}</th>
                                    <th scope="col">{{ __('Fecha') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ $venta->email }}</td>
                                        <td>{{ $pelis[$venta->id] }}</td>
                                        <td>{{ $venta->precio }} €</td>
                                        <td>{{ $venta->created_at }}</td>
                                        <td>
                                            <form action="{{ route('admin.sales.destroy', $venta->id) }}"
                                                class="form-borrar" method="POST">
                                                @csrf
                                                @method('delete')

                                            </form>
                                            <a href="{{ route('admin.sales.show', $venta->id) }}"
                                                class='editar btn btn-info'><i class='fas fa-eye'></i></a>
                                            {{-- <a href="{{ route('admin.sales.edit', $venta->id) }}"
                                                class='editar btn btn-primary ml-2'><i class='fas fa-edit'></i></a> --}}
                                            <button class='borrar-registro btn btn-danger text-white'><i
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
                "order": [[ 4, "desc" ]],
                language: {
                url: '{{ asset('js/datatable-lang/es.json') }}'
                }
                });
            @else
                $('#datatable').DataTable({
                "order": [[ 4, "desc" ]]
                });
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
