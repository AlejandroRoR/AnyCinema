<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        $precios = Price::all();

        return view('backend.prices.index', ['precios' => $precios]);
    }

    public function create()
    {
        return view('backend.prices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'lunes' => ['unique:prices,lunes'],
            'martes' => ['unique:prices,martes'],
            'miercoles' => ['unique:prices,miercoles'],
            'jueves' => ['unique:prices,jueves'],
            'viernes' => ['unique:prices,viernes'],
            'sabado' => ['unique:prices,sabado'],
            'domingo' => ['unique:prices,domingo'],
        ]);

        $precio = new Price();

        $precio->nombre = $request->name;
        $precio->precio = $request->price;
        $precio->lunes = $request->lunes;
        $precio->martes = $request->martes;
        $precio->miercoles = $request->miercoles;
        $precio->jueves = $request->jueves;
        $precio->viernes = $request->viernes;
        $precio->sabado = $request->sabado;
        $precio->domingo = $request->domingo;
        $precio->fecha = $request->fecha;


        $precio->save();

        return redirect()->route('admin.prices.show', $precio);
    }

    public function show(Price $precio)
    {
        return view('backend.prices.show', ['precio' => $precio]);
    }

    public function edit(Price $precio)
    {
        return view('backend.prices.edit', ['precio' => $precio]);
    }

    public function update(Request $request, Price $precio)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'lunes' => ['unique:prices,lunes,'.$precio->id.''],
            'martes' => ['unique:prices,martes,'.$precio->id.''],
            'miercoles' => ['unique:prices,miercoles,'.$precio->id.''],
            'jueves' => ['unique:prices,jueves,'.$precio->id.''],
            'viernes' => ['unique:prices,viernes,'.$precio->id.''],
            'sabado' => ['unique:prices,sabado,'.$precio->id.''],
            'domingo' => ['unique:prices,domingo,'.$precio->id.''],
        ]);

        $precio->nombre = $request->name;
        $precio->precio = $request->price;
        $precio->lunes = $request->lunes;
        $precio->martes = $request->martes;
        $precio->miercoles = $request->miercoles;
        $precio->jueves = $request->jueves;
        $precio->viernes = $request->viernes;
        $precio->sabado = $request->sabado;
        $precio->domingo = $request->domingo;
        $precio->fecha = $request->fecha;


        $precio->save();
        return redirect()->route('admin.prices.show', $precio);
    }

    public function destroy(Price $precio)
    {
        $precio->delete();
        return redirect()->route('admin.prices');
    }
}
