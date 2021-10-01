<?php

namespace App\Http\Controllers;

use App\Models\Cartelera;
use App\Models\Movies;
use App\Models\Rating;
use App\Models\Sales;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $cartelera;
    private $fecha7dias;
    private $fechaHoy;
    /**
     * Esta funcion si esta activa solo pueden entrar los logueados.
     *
     * @return void
     */
    public function __construct()
    {
        //Calculamos la cartelera que corresponde con la fecha que estamos
        $carteleraT = Cartelera::all();
        $this->fechaHoy = date("Y-m-d");
        $this->fecha7dias = date("Y-m-d",strtotime($this->fechaHoy."+ 1 week")); 
        $this->cartelera = 0;

        foreach ($carteleraT as $value) {
            $fecha_inicio = strtotime($value->fecha_inicio);
            $fecha_fin = strtotime($value->fecha_fin);
            $fechaHoyF = strtotime($this->fechaHoy);

            if (($fechaHoyF >= $fecha_inicio) && ($fechaHoyF <= $fecha_fin)) {
                $this->cartelera = $value->id;
            }
        }
    } 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Peliculas siguientes y sus sesiones
        $movies = new MovieController();
        Movies::all();
        $ids = Movies::orderBy('vote_average', 'DESC')->where('id_cartelera', $this->cartelera)->skip(5)->limit(2)->get();
        $pelis = [];
        foreach ($ids as $value) {

            $pelis[$value->id] = [$movies->getPelicula($value->id_api), Session::where('fecha', $this->fechaHoy)->where('id_pelicula', $value->id)->orderBy('hora')->get()];
        }

        // Carousel de las 4+1 peliculas mas votadas en la API
        $ids2 = Movies::orderBy('vote_average', 'DESC')->where('id_cartelera', $this->cartelera)->limit(5)->select(['id_api', 'id'])->get();
        $carousel = [];
        foreach ($ids2 as $value) {

            array_push($carousel, [$movies->getPelicula($value->id_api)['poster_path'], $value->id]);
        }

        return view('index', ['carousel' => $carousel, 'pelis' => $pelis]);
    }

    public function cartelera()
    {
        

        $ids = Session::select(['sessions.*', 'movies.id_api'])
            ->join('movies', 'movies.id', '=', 'sessions.id_pelicula')
            ->where('movies.id_cartelera', $this->cartelera)
            ->where('fecha','>=', $this->fechaHoy)
            ->where('fecha','<', $this->fecha7dias)
            ->orderBy('fecha')
            ->orderBy('hora','ASC')
            ->get();
        // Coger toda la informacion de la pelicula
        $movies = new MovieController();
        $pelis = [];
        foreach ($ids as $value) {
            if (array_key_exists($value->fecha, $pelis)) {
                $pelis[$value->fecha] +=  [$value->id => [$movies->getPelicula($value->id_api), $value->hora]];
            } else {
                $pelis[$value->fecha] = [$value->id => [$movies->getPelicula($value->id_api), $value->hora]];
            }
        }

        return view('cartelera', ['pelis' => $pelis]);
    }

    public function pelicula(Movies $peli)
    {
        // Coger todas las sessiones de la pelicula
        $fechaHoy = date("Y-m-d");
        $sesiones = Session::where('fecha', $fechaHoy)->where('id_pelicula', $peli->id)->get();

        // Coger toda la informacion de la pelicula
        $movies = new MovieController();
        $pelicula = $movies->getPelicula($peli->id_api);
        $permiso = false;

        if(Auth::check()){
            $valoracionPermisos = Rating::where('id_pelicula_api', $peli->id_api)
            ->where('id_user', Auth::user()->id)
            ->count();
            $ventas = Sales::where('id_usuario', Auth::user()->id)
            ->where('id_pelicula_api', $peli->id_api)
            ->where('cancelado', 0)
            ->count();
            if($valoracionPermisos == 0 && $ventas ){
                $permiso = true;
            }
        }
        
        $valoraciones = Rating::where('id_pelicula_api', $peli->id_api)
        ->select(['ratings.*', 'users.email','users.name','users.img'])
        ->join('users', 'users.id', '=', 'ratings.id_user')
        ->get();
        $totalpuntos = 0;
        $totalcoments = $valoraciones->count();
        foreach ($valoraciones as $value) {
            $totalpuntos += $value->puntuacion;
        }
        return view('peliculas.detail', [
            'pelicula' => $pelicula,
             'sesiones' => $sesiones,
              'valoraciones' => $valoraciones,
               'permitir' => $permiso,
                'totalpuntos' => $totalpuntos,
                'totalcoments' => $totalcoments
                ]);
    }

    public function sobremi()
    {
        return view('sobremi');
    }

    public function buscarSesion(Request $request)
    {
        $request->validate([
            'fecha' => ['required', 'date', 'after_or_equal:today']
        ]);

         $ids = Session::select(['sessions.*', 'movies.id_api'])
            ->join('movies', 'movies.id', '=', 'sessions.id_pelicula')
            ->where('movies.id_cartelera', $this->cartelera)
            ->where('fecha','=', $request->fecha)
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();
        // Coger toda la informacion de la pelicula
        $movies = new MovieController();
        $pelis = [];
        foreach ($ids as $value) {
            if (array_key_exists($value->fecha, $pelis)) {
                $pelis[$value->fecha] += [$value->id => [$movies->getPelicula($value->id_api), $value->hora]];
            } else {
                $pelis[$value->fecha] = [$value->id => [$movies->getPelicula($value->id_api), $value->hora]];
            }
        }
        return view('peliculas.bucadorPeli', ['pelis' => $pelis]);
    }
}
