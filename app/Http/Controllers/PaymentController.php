<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\SeatsBusy;
use App\Models\Session;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Refund;
use PayPal\Api\Sale;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class PaymentController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $payPalConfig = Config::get('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $payPalConfig['client_id'],
                $payPalConfig['secret']
            )
        );

        $this->apiContext->setConfig($payPalConfig['settings']);
    }

    public function pagarPaypal(Request $request)
    {
        // Calcula el total del precio
        $total = 0;
        foreach ($request->total as $key => $value) {
            $total += explode("-", $value)[2];
        }
        //return $total;


        // Crea el pago
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($total);
        $amount->setCurrency('EUR');

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription("Compra de entradas.");

        $callBackUrl = route('paypal.status');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callBackUrl)
            ->setCancelUrl($callBackUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        // After Step 3
        try {
            // Guarda en la sesion las sillas selecionadas, el id de la peli y la sesion
            session(['valid' . Auth::user()->id => true]);

            session(['compra' . Auth::user()->id => [$request->total, $request->peli, $request->sesion]]);
            $payment->create($this->apiContext);


            //echo $payment;

            return redirect()->away($payment->getApprovalLink());
        } catch (PayPalConnectionException $ex) {
            return $ex->getData();
        }
    }

    public function statusPaypal(Request $request)
    {
        // Recoge las variables necesarias para validar el pago
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');

        if (!$paymentId || !$payerId || !$token) {
            return redirect()->route('home');
        }
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $this->apiContext);
        $valido = session('valid' . Auth::user()->id);
        $ses = session('compra' . Auth::user()->id);
        $t = 0;
        foreach ($ses[0] as $key => $value) {
            $t += explode("-", $value)[2];
        }
        // Validamos el pago y creamos la venta
        if ($result->getState() === 'approved' && $valido) {
            $ids = Session::select(['sessions.id_pelicula', 'sessions.fecha', 'movies.id_api'])
                ->join('movies', 'movies.id', '=', 'sessions.id_pelicula')
                ->where('sessions.id', $ses[2])
                ->orderBy('fecha')
                ->get();
            $insesion = Session::select(['sessions.id', 'sessions.id_sala', 'rooms.n_filas', 'rooms.n_columnas'])
                ->join('rooms', 'rooms.id', '=', 'sessions.id_sala')
                ->where('sessions.id', $ses[2])
                ->get()[0];
            $totalsala = $insesion->n_filas * $insesion->n_columnas;
            $ocu = SeatsBusy::where('id_sala', $insesion->id_sala)->count();
            $totalasientos = $totalsala - $ocu;

            // Crea una venta
            $venta = new Sales();
            $venta->id_usuario = Auth::user()->id;
            $venta->id_pelicula_api = $ses[1];
            $venta->id_paypal = $result->transactions[0]->related_resources[0]->sale->id;
            $venta->precio = $t;
            $venta->save();

            // Crea todos los tickets de la venta
            foreach ($ses[0] as $key => $value) {
                $ticket = new Ticket();
                $ticket->id_venta = $venta->id;
                $ticket->id_sesion = $ses[2];
                $ticket->fila = explode("-", $value)[0];
                $ticket->columna = explode("-", $value)[1];
                $ticket->precio = explode("-", $value)[2];
                $ticket->save();
            }

            $totaltickets = Ticket::where('id_sesion', $ses[2])->count();
            if ($totalasientos == $totaltickets) {
                $sesion = Session::find($ses[2]);
                $sesion->agotada = 1;
                $sesion->save();
            }

            session(['valid' . Auth::user()->id => false]);
            session(['idsesion' . Auth::user()->id => $venta->id]);
        }

        return view('peliculas.resultpay', ['result' => $result, 'asientos' => $ses[0], 'total' => $t, 'sesion' => session('idsesion' . Auth::user()->id)]);
    }

    public function devolverPaypal(Sales $venta)
    {
        $amt = new Amount();
        $amt->setTotal($venta->precio)
            ->setCurrency('EUR');

        $refund = new Refund();
        $refund->setAmount($amt);

        $sale = new Sale();
        $sale->setId($venta->id_paypal);

        try {
            $refundedSale = $sale->refundSale($refund, $this->apiContext);
        } catch (PayPalConnectionException $ex) {
            return $ex->getData();

        } catch (Exception $ex) {
            return $ex;
        }
        if($refundedSale->getState() === 'completed') {
            $venta->cancelado = 1;
            $venta->save();
            Ticket::where('id_venta',$venta->id)->delete();
        }
        return redirect()->back();
    }
}
