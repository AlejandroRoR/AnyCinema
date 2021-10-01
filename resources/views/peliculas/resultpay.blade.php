@extends('layouts.app')



@section('content')
    {{-- <div class="product_image_area mt-5">
        <div class="container">

            

        </div>
    </div> --}}
    <!--================Order Details Area =================-->
    <section class="order_details section_gap product_image_area mt-5">
        <div class="container">

            @if ($result->getState() !== 'approved')
                <h3 class="text-danger text-center my-5 py-5">{{ __('Lo sentimos, su pago no ha sido aceptado') }}</h3>
            @else
                <h3 class="title_confirmation mt-5">{{ __('Gracias por tu compra. Esperamos verte pronto.') }}</h3>
                <div class="text-center">
                    <a href="{{ route('descargar.entradas', $sesion) }}"
                    class='btn btn-success text-white'>{{ __('Descargar Entradas') }}</a>
                </div>
                
                <div class="order_details_table">
                    <h2>{{ __('Detalles de la compra') }}</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Entrada') }}</th>
                                    <th scope="col"></th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($asientos as $asi)
                                    <tr>
                                        <td>
                                            <p>{{ __('Fila') }}: {{ explode("-", $asi)[0] }} - {{ __('Butaca') }}: {{ explode("-", $asi)[1] }}</p>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <p>{{ explode("-", $asi)[2] }} €</p>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        <p><b>TOTAL</b></p>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <p><b>{{ $total }} €</b></p>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            @endif


            <div class="text-center mt-5">
                <a href="{{ route('home') }}" class="genric-btn primary">{{ __('Volver al Inicio') }}</a>
            </div>
        </div>
    </section>
    <!--================End Order Details Area =================-->
@endsection
