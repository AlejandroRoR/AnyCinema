<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MovieController;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(){
        $valoraciones = Rating::select(['ratings.*','users.email'])
        ->join('users', 'users.id', '=', 'ratings.id_user')
        ->orderBy('created_at')->get();
        $pelis = [];
        $peliculas = new MovieController();
        foreach ($valoraciones as $value) {
            $pelis[$value->id] = $peliculas->getPelicula($value->id_pelicula_api)['title'];
        }
        return view('backend.ratings.index', ['valoraciones' => $valoraciones, 'peli' => $pelis]);
    }

    public function create(){
        $usuarios = User::all();
        return view('backend.ratings.create', ['usuarios' => $usuarios]);
    }

    public function store(Request $request){
        $valoracion = new Rating();

        $valoracion->id_user = $request->iduser;
        $valoracion->id_pelicula = $request->idpeli;
        $valoracion->puntuacion = $request->npunt;
        $valoracion->comentario = $request->coment;
        $valoracion->save();

        return redirect()->route('admin.ratings.show', $valoracion);
    }

    public function show(Rating $valoracion){
        $valoraciones = Rating::select(['ratings.*','users.email'])
        ->join('users', 'users.id', '=', 'ratings.id_user')
        ->where('ratings.id', $valoracion->id)->get()[0];

        $peliculas = new MovieController();
        $pelis[$valoracion->id] = $peliculas->getPelicula($valoracion->id_pelicula_api)['title'];

        return view('backend.ratings.show', ['valoracion' => $valoraciones,'peli' => $pelis]);
    }

    public function edit(Rating $valoracion){
        $usuarios = User::all();
        return view('backend.ratings.edit', ['valoracion' => $valoracion, 'usuarios' => $usuarios]);
    }

    public function update(Request $request, Rating $valoracion){
        $valoracion->id_user = $request->iduser;
        $valoracion->id_pelicula = $request->idpeli;
        $valoracion->puntuacion = $request->npunt;
        $valoracion->comentario = $request->coment;
        $valoracion->save();
        $valoracion->save();
        return redirect()->route('admin.ratings.show', $valoracion);
    }

    public function destroy(Rating $valoracion){
        $valoracion->delete();
        return redirect()->route('admin.ratings', $valoracion);
    }
}
