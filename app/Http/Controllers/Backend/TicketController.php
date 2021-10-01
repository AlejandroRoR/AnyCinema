<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Models\Session;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(){
        $entradas = Ticket::all();

        return view('backend.tickets.index', ['entradas' => $entradas]);
    }

    public function create(){
        $ventas = Sales::all();
        $sesiones = Session::all();
        return view('backend.tickets.create', ['ventas' => $ventas, 'sesiones' => $sesiones]);
    }

    public function store(Request $request){
        $entrada = new Ticket();

        $entrada->id_venta = $request->venta;
        $entrada->id_sesion = $request->sesion;
        $entrada->fila = $request->row;
        $entrada->columna = $request->col;
        $entrada->precio = $request->precio;
        $entrada->save();

        return redirect()->route('admin.tickets.show', $entrada);
    }

    public function show(Ticket $entrada){
        return view('backend.tickets.show', ['entrada' => $entrada]);
    }

    public function edit(Ticket $entrada){
        $ventas = Sales::all();
        $sesiones = Session::all();
        return view('backend.tickets.edit', ['entrada' => $entrada, 'ventas' => $ventas, 'sesiones' => $sesiones]);
    }

    public function update(Request $request, Ticket $entrada){
        $entrada->id_venta = $request->venta;
        $entrada->id_sesion = $request->sesion;
        $entrada->fila = $request->row;
        $entrada->columna = $request->col;
        $entrada->precio = $request->precio;
        $entrada->save();
        return redirect()->route('admin.tickets.show', $entrada);
    }

    public function destroy(Ticket $entrada){
        $entrada->delete();
        return redirect()->route('admin.tickets', $entrada);
    }
}
