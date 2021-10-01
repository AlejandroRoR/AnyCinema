<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MovieController;
use App\Models\Cartelera;
use App\Models\Movies;
use App\Models\Room;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index(){
        $sesiones = Session::select(['sessions.*', 'movies.id_api', 'rooms.n_sala'])
        ->join('movies', 'movies.id', '=', 'sessions.id_pelicula')
        ->join('rooms', 'rooms.id', '=', 'sessions.id_sala')
        ->get();

        $peliculas = new MovieController();
        $tituloPelis = [];
        foreach ($sesiones as $key => $value) {
            array_push($tituloPelis, [$key => $peliculas->getPelicula($value->id_api)['title']]);
        }


        return view('backend.sessions.index', ['sesiones' => $sesiones, 'titulos' => $tituloPelis]);
    }

    public function create(){
        $salas = Room::all();
        $carteleras = Cartelera::all();
        return view('backend.sessions.create', ['salas' => $salas, 'carteleras' => $carteleras]);
    }

    public function getNomPelis(Request $request){
        $pelis = [];
        $baseP = Movies::where('id_cartelera', $request->idcartelera)->get();
        $peliculas = new MovieController();
        foreach ($baseP as $value) {
            $pelis[$value->id] = $peliculas->getPelicula($value->id_api)['title'];
        }
        return $pelis;
    }
        
    public function store(Request $request){

        $request->validate([
            'idcart' => ['required', 'integer'],
            'idpeli' => ['required', 'integer'],
            'idsala' => ['required', 'integer'],
            'fecha' => ['required', 'date','after_or_equal:today'],
            'hora' => ['required']
        ]);

        $sesion = new Session();

        $sesion->id_pelicula = $request->idpeli;
        $sesion->id_sala = $request->idsala;
        $sesion->fecha = $request->fecha;
        $sesion->hora = $request->hora;
        $sesion->save();

        return redirect()->route('admin.sessions.show', $sesion);
    }

    public function show(Session $sesion){
        $sesiones = Session::where('sessions.id', $sesion->id)
        ->select(['sessions.*', 'movies.id_api', 'rooms.n_sala'])
        
        ->join('movies', 'movies.id', '=', 'sessions.id_pelicula')
        ->join('rooms', 'rooms.id', '=', 'sessions.id_sala')
        ->get();
        $peliculas = new MovieController();
        $tituloPelis = [];
        foreach ($sesiones as $key => $value) {
            array_push($tituloPelis, [$key => $peliculas->getPelicula($value->id_api)['title']]);
        }
        
        return view('backend.sessions.show', ['sesion' => $sesiones[0], 'titulo'=> $tituloPelis]);
    }

    public function edit(Session $sesion){
        $peliculas = new MovieController();
        $peli = $peliculas->getPelicula(Movies::find($sesion->id_pelicula)->id_api)['title'];
        $salas = Room::all();
        return view('backend.sessions.edit', ['sesion' => $sesion, 'salas' => $salas, 'peli' => $peli]);
    }

    public function update(Request $request, Session $sesion){

        $request->validate([
            'idsala' => ['required', 'integer'],
            'fecha' => ['required', 'date'],
            'hora' => ['required']
        ]);

        $sesion->id_sala = $request->idsala;
        $sesion->fecha = $request->fecha;
        $sesion->hora = $request->hora;
        $sesion->save();
        return redirect()->route('admin.sessions.show', $sesion);
    }

    public function destroy(Session $sesion){
        $sesion->delete();
        return redirect()->route('admin.sessions');
    }
}
