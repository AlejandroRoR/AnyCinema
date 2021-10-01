@extends('backend.layouts.app')

@section('title')
    {{ __('Salas de Cine') }}
@endsection

@section('page-head')
    {{ __('Salas de Cine') }}
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
                    <a href="{{ route('admin.rooms.create') }}"
                        class="btn btn-success text-white mb-4">{{ __('Crear Sala') }}</a>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Nº de Sala') }}</th>
                                    <th scope="col">{{ __('Nº de Filas') }}</th>
                                    <th scope="col">{{ __('Nº de Butacas') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sala as $room)
                                    <tr>
                                        <td>{{ $room->id }}</td>
                                        <td>{{ $room->n_sala }}</td>
                                        <td>{{ $room->n_filas }}</td>
                                        <td>{{ $room->n_columnas }}</td>
                                        <td>
                                            <form action="{{ route('admin.rooms.destroy', $room->id) }}"
                                                class="form-borrar" method="POST">
                                                @csrf
                                                @method('delete')
                                            </form>
                                            <a href="{{ route('admin.rooms.show', $room->id) }}"
                                                class='editar btn btn-info'><i class='fas fa-eye'></i></a>
                                            <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                                class='editar btn btn-primary'><i class='fas fa-edit'></i></a>
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
