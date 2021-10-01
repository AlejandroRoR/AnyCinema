<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index() {
        $usuarios = User::all();

        return view('backend.users.index', ['usuarios' => $usuarios]);
    }

    public function create(){
        return view('backend.users.create');
    }

    public function store(Request $request){

        $request->validate([
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'name' => ['required', 'string', 'max:255'],
            'pass' => ['required', 'string', 'min:8']
        ]);

        $usuario = new User();

        $usuario->email = $request->correo;
        $usuario->name = $request->name;
        $usuario->password = Hash::make($request->pass);
        $usuario->rol = $request->tipo;
        if ($archivo = $request->file('avatar')) {
            $nombre = $archivo->getClientOriginalName();
            $archivo->move('uploads/avatars', $nombre);
            $usuario->img = $nombre;
        }
        $usuario->save();

        return redirect()->route('admin.users.show', $usuario);
    }

    public function show(User $usuario){
        return view('backend.users.show', ['usuario' => $usuario]);
    }

    public function edit(User $usuario){
        return view('backend.users.edit', ['usuario' => $usuario]);
    }

    public function update(Request $request, User $usuario){

        $request->validate([
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$usuario->id.''],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $usuario->email = $request->correo;
        $usuario->name = $request->name;
        $usuario->rol = $request->tipo;
        if ($archivo = $request->file('avatar')) {
            $nombre = $archivo->getClientOriginalName();
            $archivo->move('uploads/avatars', $nombre);
            $usuario->img = $nombre;
        }
        $usuario->save();

        return redirect()->route('admin.users.show', $usuario);
    }

    public function destroy(User $usuario){
        $usuario->delete();
        return redirect()->route('admin.users', $usuario);
    }
    
}
