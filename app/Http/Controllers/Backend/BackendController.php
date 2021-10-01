<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function index()
    {
        $valoraciones = Rating::orderBy('created_at', 'DESC')->select(['ratings.*', 'users.img', 'users.name'])->join('users', 'users.id', '=', 'ratings.id_user')->get();
        //$valoraciones = Rating::orderBy('created_at')->limit(5)->get();
        $usuarios = User::orderBy('created_at', 'DESC')->limit(5)->get();

        return view('backend.index', ['valoraciones' => $valoraciones, 'usuarios' => $usuarios]);
    }
}
