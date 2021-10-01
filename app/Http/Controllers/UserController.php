<?php

namespace App\Http\Controllers;

use App\Models\Movies;
use App\Models\Price;
use App\Models\Rating;
use App\Models\Room;
use App\Models\Sales;
use App\Models\SeatsBusy;
use App\Models\Session;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function perfil()
    {
        $user = User::find(Auth::user()->id);
        return view('users.settings', ['usuario' => $user]);
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$usuario->id.''],
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['image','mimes:jpeg,png,jpg']
        ]);
        $usuario->name = $request->name;
        $usuario->email = $request->correo;
        if ($archivo = $request->file('avatar')) {
            $nombre = time().$archivo->getClientOriginalName();
            $archivo->move('uploads/avatars', $nombre);
            $usuario->img = $nombre;
        }
        $usuario->save();

        return redirect()->route('users.config');
    }

    public function cambiarContra(Request $request, User $user)
    {
        $request->validate([
            'old_password' => ['required','string', 'min:8'],
            'password' => ['required','string', 'min:8'],
            'password_new' => ['required','string', 'min:8'],
        ]);

        //Comprueba la contraseña actual con la nueva y las cambia
        if (Hash::check($request->old_password, Auth::user()->password)) {
            if ($request->password == $request->password_new) {
                User::where('id', '=', Auth::user()->id)
                ->update(['password' => Hash::make($request->password)]);
                return redirect()->route('users.config');
            } else {
                return back()->with('errorPass2', __('Las contraseñas no coinciden.'));
            }
        } else {
            return back()->with('errorPass1', __('La contraseña no coincide con la actual.'));
        }
    }

    public function buySesion(Session $sesion)
    {
        // Recoge la pelicula de la api
        $pelis = new MovieController();
        $pelicula = $pelis->getPelicula(Movies::find($sesion->id_pelicula)->id_api);

        // Recogemos los datos necesarios para montar la sala
        $tickets = Ticket::where('id_sesion', $sesion->id)->get();
        $sala = Room::where('id', $sesion->id_sala)->first();
        $salaOcu = SeatsBusy::where('id_sala', $sesion->id_sala)->get();

        // Calculamos el precio de la sesion.
        $t = 0;
        if (sizeof(Price::whereNotNull('fecha')->get())) {
            $precio = Price::whereNotNull('fecha')->get();
            foreach ($precio as $key => $value) {
                if ($value->fecha == $sesion->fecha) {
                    $t = $value->precio;
                }
            }
        }
        if ($t == 0) {
            $dia = "";
            $day = date("l", strtotime($sesion->fecha));
            switch ($day) {
                case "Monday":
                    $dia = "lunes";
                    break;
                case "Tuesday":
                    $dia = "martes";
                    break;
                case "Wednesday":
                    $dia = "miercoles";
                    break;
                case "Thursday":
                    $dia = "jueves";
                    break;
                case "Friday":
                    $dia = "viernes";
                    break;
                case "Saturday":
                    $dia = "sabado";
                    break;
                case "Sunday":
                    $dia = "domingo";
                    break;
            }
            $t = Price::where($dia, 1)->get();
            if(sizeof($t)){
                $t = $t[0]->precio;
            } else{
                $t = 5;
            }
        }
        
        return view('peliculas.comprar', ['sala' => $sala, 'ocupadas' => $salaOcu, 'sesion' => $sesion, 'precio' => $t, 'pelicula' => $pelicula, 'tickets' => $tickets]);
    }

    public function compras()
    {
        $ventas = Sales::where('id_usuario', Auth::user()->id)->get();
        $pelis = [];
        $peliculas = new MovieController();
        foreach ($ventas as $value) {
            $pelis[$value->id] = $peliculas->getPelicula($value->id_pelicula_api)['title'];
        }
        return view('users.historial', ['ventas' => $ventas, 'pelis' => $pelis]);
    }

    public function addValoracion(Request $request)
    {
        $request->validate([
            'puntuacion' => ['required', 'integer'],
            'coment' => ['required', 'string'],
        ]);
        $valor = new Rating();
        $valor->id_user = Auth::user()->id;
        $valor->id_pelicula_api = $request->peli;
        $valor->puntuacion = $request->puntuacion;
        $valor->comentario = $request->coment;
        $valor->save();
        return back();
    }

    public function exportEntradas(Sales $venta)
    {
        //return view('pdf.entradas');
        $tickets = Ticket::where('id_venta', $venta->id)->get();
        $pdf = PDF::loadView('pdf.entradas', ['tickets' => $tickets]);
        return $pdf->download('entradas.pdf');
    }
}
