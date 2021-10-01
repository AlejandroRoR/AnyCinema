@extends('layouts.app')
@section('css')
    <style type="text/css">
        .titulourl{
            color: #FFBA00;
        }
        .titulourl:hover{
            color: #c99300;
        }
    </style>
@endsection
@section('content')

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>{{ __('Comprar Entradas') }}</h1>

                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-8">
                        <h3><a href="{{ route('pelicula.detallada', $sesion->id_pelicula) }}" class="titulourl">{{ $pelicula['title'] }}</a> - {{ $sesion->hora }}</h3>
                        <div class="mensaje alert alert-warning text-center" role="alert">
                            {{ __('Selecciona los asientos que quieras.') }}
                        </div>

                        <div class="mostrarsala d-flex justify-content-center mb-4 mt-5">
                            <table class="border sillas">
                                @for ($i = 1; $i <= $sala->n_filas; $i++)
                                    <tr>
                                        @for ($j = 1; $j <= $sala->n_columnas; $j++)

                                            <?php
                                            $bandera = false;
                                            foreach ($ocupadas as $value) {
                                            if ($i == $value->n_fila && $j == $value->n_columna) {
                                            $bandera = true;
                                            }
                                            }
                                            $ocup = false;
                                            foreach ($tickets as $tik) {
                                            if ($i == $tik->fila && $j == $tik->columna) {
                                            $ocup = true;
                                            }
                                            }
                                            ?>
                                            @if (!$ocup)
                                                @if (!$bandera)
                                                    <td class="p-1 clickable">
                                                @else
                                                    <td class="p-1">
                                                @endif
                                            @else
                                                <td class="p-1">
                                            @endif


                                            @if (!$bandera)
                                                @if ($ocup)
                                                    <img src="{{ asset('imagenes/asientos/seat_busy.png') }}"
                                                        id="{{ $i . '-' . $j }}" alt="Silla">
                                                @else
                                                    <img src="{{ asset('imagenes/asientos/seat.png') }}"
                                                        id="{{ $i . '-' . $j }}"
                                                        precio="{{ $precio }}"
                                                        alt="Silla">
                                                @endif
                                            @endif

                                            </td>
                                        @endfor
                                    </tr>
                                @endfor
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="order_box">
                            <h2>{{ __('Tu Compra') }}</h2>
                            <ul class="list listacompra">
                                <li>
                                    <p>{{ __('Entrada') }} <span>Total</span></p>
                                </li>

                            </ul>
                            <hr>
                            <ul class="list list_2">
                                {{-- <li><a href="#">Subtotal <span>$2160.00</span></a></li> --}}
                                <li>
                                    <p>Total <span id="precioT">0 €</span></p>
                                </li>
                            </ul>
                            <small>{{ __('IVA incluido') }}</small>
                            {{-- <div class="payment_item active">
                                <div class="radion_btn">
                                    <input type="radio" id="f-option6" name="selector">
                                    <label for="f-option6">Paypal </label>
                                    <img src="img/product/card.jpg" alt="">
                                    <div class="check"></div>
                                </div>
                                <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                                    account.</p>
                            </div> --}}
                            <hr>
                            {{-- <div class="creat_account">
                                <input type="checkbox" id="f-option4" name="selector">
                                <label for="f-option4">I’ve read and accept the </label>
                                <a href="#">terms & conditions*</a>
                            </div> --}}
                            <form action="{{ route('paypal.pagar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="peli" value="{{ $pelicula['id'] }}">
                                <input type="hidden" name="sesion" value="{{ $sesion->id }}">
                                <div class="precioInput">

                                </div>
                                <button type="submit" id="btnPagar" class="primary-btn w-100 botonsubmit">{{ __('Pay with Paypal') }}</button>
                            </form>
                            {{-- <a class="primary-btn" href="#">Proceed to Paypal</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->

@endsection

@section('javascript')

    <script>
        $(() => {
            $('#btnPagar').prop('disabled', true);
            $('.sillas .clickable').css('cursor', 'pointer'); // 'default' to revert
            $('.sillas .clickable').on("click", cambiar);

        })

        function cambiar() {
            total = 0;
            if ($(this).find("img").val() == "0") {
                $(this).attr("id", "");
                $(this).find("img").attr('src', '{{ asset('imagenes/asientos/seat.png') }}');
                $(this).find("img").val("1");
                $('.listacompra').find("#" + $(this).find("img").attr("id")).remove()
                $('.precioInput').find("#" + $(this).find("img").attr("id")).remove()
            } else {
                $(this).attr("id", "marcado");
                $(this).find("img").attr('src', '{{ asset('imagenes/asientos/seat_free.png') }}');
                $(this).find("img").val("0");
                $nombre = "{{ __('Fila') }}: " + ($(this).find("img").attr("id")).split("-")[0] + " - {{ __('Butaca') }}: " + ($(this).find("img")
                    .attr("id")).split("-")[1]
                $('.listacompra').append('<li id="' + $(this).find("img").attr("id") + '"><p>' + $nombre +
                    ' <span class="last">' + $(this).find("img").attr("precio") + ' €</span></p></li>');
                $('.precioInput').append('<input type="hidden" id="' + $(this).find("img").attr("id") +
                    '" name="total[]" value="' + $(this).find("img").attr("id") + '-' + $(this).find("img").attr(
                        "precio") + '">');
            }
            $('.mostrarsala').find('td#marcado').each(function(ind, obj) {
                total += parseFloat($(obj).find("img").attr("precio"));
            });
            if (total == 0) {
                $('#btnPagar').prop('disabled', true);
            } else {
                $('#btnPagar').prop('disabled', false);
            }
            $('#precioT').text(total + " €");

        }

    </script>

@endsection
