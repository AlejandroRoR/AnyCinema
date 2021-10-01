<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{

    public function searchPeliculas(Request $request)
    {
        return Http::get('https://api.themoviedb.org/3/search/movie?api_key=b6283c4a69d1749df7d97803e78ffb49&language='.App::getLocale().'&query='.$request->busqueda.'')
        ->json();
    }

    public function getPeliculas()
    {
        $pagina = 1;
        return Http::get('https://api.themoviedb.org/3/movie/popular?api_key=b6283c4a69d1749df7d97803e78ffb49&language='.App::getLocale().'&page='.$pagina)
        ->json();
    }

    public function getPelicula($peli)
    {
        return Http::get('https://api.themoviedb.org/3/movie/'.$peli.'?api_key=b6283c4a69d1749df7d97803e78ffb49&language='.App::getLocale().'')
        ->json();
    }
}
