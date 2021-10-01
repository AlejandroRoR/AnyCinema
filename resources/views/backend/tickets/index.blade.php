@extends('backend.layouts.app')

@section('title', 'Entradas')

@section('content')
    <div class="container">

        <div class="col-12 text-center">
            <h3>Entradas</h3>
        </div>
{{--         <div class="botones">
            <a href="{{ route('admin.tickets.create') }}" class="btn btn-success">Crear Entrada</a>
        </div> --}}
        <div class="tabla mt-4">
            <table class="table text-center datatable">
                <thead class="thead-dark ">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID Venta</th>
                        <th scope="col">ID Sesión</th>
                        <th scope="col">Fila</th>
                        <th scope="col">Columna</th>
                        <th scope="col">Precio</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entradas as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->id_venta }}</td>
                            <td>{{ $ticket->id_sesion }}</td>
                            <td>{{ $ticket->fila }}</td>
                            <td>{{ $ticket->columna }}</td>
                            <td>{{ $ticket->precio }}</td>
                            <td>
                               
{{--                                 <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" class="ml-2" method="POST">
                                    @csrf
                                    @method('delete') --}}
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class='editar btn btn-info'><i class='fas fa-eye'></i></a>
{{--                                     <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class='editar btn btn-primary ml-2'><i class='fas fa-edit'></i></a>
                                    <button type="submit" class='editar btn btn-danger'><i class='fas fa-trash'></i></button>
                                </form> --}}
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
<script>
   $('.datatable').DataTable({
       language: {
           url: '{{ asset('js/datatable-lang/es.json') }}'
       }
   });
</script>

@endsection