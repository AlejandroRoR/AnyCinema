<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MovieController;
use App\Models\Cartelera;
use App\Models\Movies;
use App\Rules\FechaCartelera;
use Illuminate\Http\Request;

class CarteleraController extends Controller
{
    public function index()
    {
        $cartelera = Cartelera::all();
        return view('backend.carteleras.index', compact('cartelera'));
    }

    public function create()
    {
        return view('backend.carteleras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fini' => ['required', 'date'],
            'ffin' => ['required', 'date','after_or_equal:fini']
        ]);

        if(Cartelera::count() != 0){
            $lastFecha = Cartelera::select('fecha_fin')->orderBy('fecha_fin', 'DESC')->limit(1)->get()[0]['fecha_fin'];

            if (($request->fini < $lastFecha) || ($request->ffin < $lastFecha)) {
                return redirect()->back()->with('errorFecha', __('El rango de fecha introducido es invalido, porfavor introduzca un rango válido.'));;
            }
        }
        

        $cartelera = new Cartelera();
        $cartelera->fecha_inicio = $request->fini;
        $cartelera->fecha_fin = $request->ffin;
        $cartelera->save();

        foreach ($request->peliculas as $value) {
            $pelicula = new Movies();
            $pelicula->id_cartelera = $cartelera->id;
            $pelicula->id_api = $value;
            $pelis = new MovieController;
            $pelicula->vote_average = $pelis->getPelicula($value)['vote_average'];
            $pelicula->save();
        }

        return redirect()->route('admin.carteleras.show', $cartelera);
    }

    public function show(Cartelera $cartelera)
    {
        // Coger toda la informacion de las peliculas de la cartelera
        $ids = Movies::where('id_cartelera',$cartelera->id)->get();
        $movies = new MovieController();
        $pelis = [];
        foreach ($ids as $value) {
            array_push($pelis, $movies->getPelicula($value->id_api));
        }
        return view('backend.carteleras.show', ['cartelera' => $cartelera, 'pelis' => $pelis]);
    }

    public function edit(Cartelera $cartelera)
    {
        return view('backend.carteleras.edit', compact('cartelera'));
    }

    public function update(Request $request, Cartelera $cartelera)
    {
        $request->validate([
            'fini' => ['required', 'date'],
            'ffin' => ['required', 'date']
        ]);

        $lastFecha = Cartelera::select('fecha_fin')->orderby('fecha_fin', 'DESC')->limit(1)->get()[0]['fecha_fin'];

        if (($request->fini < $lastFecha) || ($request->ffin < $lastFecha) || ($request->ffin < $request->fini)) {
            return redirect()->back()->with('errorFecha', __('El rango de fecha introducido es invalido, porfavor introduzca un rango válido.'));;
        }
        
        $cartelera->fecha_inicio = $request->fini;
        $cartelera->fecha_fin = $request->ffin;
        $cartelera->save();
        return redirect()->route('admin.carteleras.show', $cartelera);
    }

    public function destroy(Cartelera $cartelera)
    {
        $cartelera->delete();
        return redirect()->route('admin.carteleras');
    }
}
