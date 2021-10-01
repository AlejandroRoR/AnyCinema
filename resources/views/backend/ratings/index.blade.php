@extends('backend.layouts.app')

@section('title')
    {{ __('Valoraciones') }}
@endsection

@section('page-head')
    {{ __('Valoraciones') }}
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
                    <a href="{{ route('admin.ratings.create') }}" class="btn btn-success">Crear Valoración</a>
                    </div> --}}
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Usuario') }}</th>
                                    <th scope="col">{{ __('Pelicula') }}</th>
                                    <th scope="col">{{ __('Puntuación') }}</th>
                                    <th scope="col">{{ __('Comentario') }}</th>
                                    <th scope="col">{{ __('Fecha') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($valoraciones as $val)
                                    <tr>
                                        <td>{{ $val->id }}</td>
                                        <td>{{ $val->email }}</td>
                                        <td>{{ $peli[$val->id] }}</td>
                                        <td>{{ $val->puntuacion }}</td>
                                        <td>{{ $val->comentario }}</td>
                                        <td>{{ $val->created_at }}</td>
                                        <td>
                                            <form action="{{ route('admin.ratings.destroy', $val->id) }}"
                                                class="form-borrar" method="POST">
                                                @csrf
                                                @method('delete')
                                            </form>

                                            <a href="{{ route('admin.ratings.show', $val->id) }}"
                                                class='editar btn btn-info'><i class='fas fa-eye'></i></a>
                                            {{-- <a href="{{ route('admin.ratings.edit', $val->id) }}"
                                                class='editar btn btn-primary'><i class='fas fa-edit'></i></a> --}}
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
                    "order": [[ 5, "desc" ]],
                language: {
                url: '{{ asset('js/datatable-lang/es.json') }}'
                }
                });
            @else
                $('#datatable').DataTable({
                    "order": [[ 5, "desc" ]]
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
