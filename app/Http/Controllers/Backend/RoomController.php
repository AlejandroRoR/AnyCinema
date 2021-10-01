<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\SeatsBusy;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $sala = Room::all();

        return view('backend.rooms.index', compact('sala'));
    }

    public function create()
    {
        return view('backend.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nsala' => ['required', 'integer','unique:rooms,n_sala'],
            'nrow' => ['required', 'integer'],
            'ncol' => ['required', 'integer']
        ]);

        $sala = new Room();

        $sala->n_sala = $request->nsala;
        $sala->n_filas = $request->nrow;
        $sala->n_columnas = $request->ncol;
        $sala->save();
        if (!empty($request->asientos)) {
            foreach ($request->asientos as $value) {
                $ocupadas = new SeatsBusy();
                $ocupadas->id_sala = $sala->id;
                $ocupadas->n_fila = explode("-", $value)[0];
                $ocupadas->n_columna = explode("-", $value)[1];
                $ocupadas->save();
            }
        }


        return redirect()->route('admin.rooms.show', $sala);
    }

    public function show(Room $sala)
    {
        $ocupadas = SeatsBusy::where('id_sala', '=', $sala->id)->get();
        return view('backend.rooms.show', ['sala' => $sala, 'ocupadas' => $ocupadas]);
    }

    public function edit(Room $sala)
    {
        $ocupadas = SeatsBusy::where('id_sala', '=', $sala->id)->get();
        return view('backend.rooms.edit', ['sala' => $sala, 'ocupadas' => $ocupadas]);
    }

    public function update(Request $request, Room $sala)
    {
        $request->validate([
            'nsala' => ['required', 'integer','unique:rooms,n_sala,'.$sala->id.''],
            'nrow' => ['required', 'integer'],
            'ncol' => ['required', 'integer']
        ]);

        $sala->n_sala = $request->nsala;
        $sala->n_filas = $request->nrow;
        $sala->n_columnas = $request->ncol;
        $sala->save();

        $ocupadas = SeatsBusy::where('id_sala', '=', $sala->id)->get();
        foreach ($ocupadas as $value) {
            $value->delete();
        }

        if (!empty($request->asientos)) {
            foreach ($request->asientos as $value) {
                $ocupadas = new SeatsBusy();
                $ocupadas->id_sala = $sala->id;
                $ocupadas->n_fila = explode("-", $value)[0];
                $ocupadas->n_columna = explode("-", $value)[1];
                $ocupadas->save();
            }
        }

        return redirect()->route('admin.rooms.show', $sala);
    }

    public function destroy(Room $sala)
    {
        $sala->delete();
        return redirect()->route('admin.rooms', $sala);
    }
}
