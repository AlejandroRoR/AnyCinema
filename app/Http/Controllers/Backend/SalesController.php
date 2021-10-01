<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MovieController;
use App\Models\Sales;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(){
        $ventas = Sales::select(['sales.*','users.email'])
        ->join('users', 'users.id', '=', 'sales.id_usuario')
        ->orderBy('created_at')->get();
        $pelis = [];
        $peliculas = new MovieController();
        foreach ($ventas as $value) {
            $pelis[$value->id] = $peliculas->getPelicula($value->id_pelicula_api)['title'];
        }

        return view('backend.sales.index', ['ventas' => $ventas, 'pelis' => $pelis]);
    }

    public function create(){
        $usuarios = User::all();
        return view('backend.sales.create', ['usuarios' => $usuarios]);
    }

    public function store(Request $request){
        $venta = new Sales();

        $venta->id_usuario = $request->iduser;
        $venta->id_pelicula = $request->idpeli;
        $venta->precio = $request->precio;
        $venta->fecha = $request->fecha;
        $venta->save();

        return redirect()->route('admin.sales.show', $venta);
    }

    public function show(Sales $venta){
        $tickets = Ticket::where('id_venta', $venta->id)->get();
        $ventas = Sales::select(['sales.*','users.email'])
        ->join('users', 'users.id', '=', 'sales.id_usuario')
        ->where('sales.id', $venta->id)->get()[0];

        $peliculas = new MovieController();
        $pelis[$ventas->id] = $peliculas->getPelicula($ventas->id_pelicula_api)['title'];

        return view('backend.sales.show', ['venta' => $ventas, 'tickets' => $tickets, 'peli' => $pelis]);
    }

    public function edit(Sales $venta){
        $usuarios = User::all();
        return view('backend.sales.edit', ['venta' => $venta, 'usuarios' => $usuarios]);
    }

    public function update(Request $request, Sales $venta){
        $venta->id_usuario = $request->iduser;
        $venta->id_pelicula = $request->idpeli;
        $venta->precio = $request->precio;
        $venta->fecha = $request->fecha;
        $venta->save();
        return redirect()->route('admin.sales.show', $venta);
    }

    public function destroy(Sales $venta){
        $venta->delete();
        return redirect()->route('admin.sales', $venta);
    }
}
