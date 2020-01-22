<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = DB::table('users')->get();
        return $users;
    }

    public function showLoginForm()
    {
        return view('auth.register');
    }

    public function StoreUser(StoreUserRequest $request)
    {
        $usuario = $request->all();
        $usuario['password'] = bcrypt($usuario['password']);
        User::create($usuario);
    }

    public function DeleteUser($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
    }

    public function updateUser(UpdateUserRequest $request)
    {
        $usuario = User::findOrFail($request->id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->type = $request->type;

        if($request->password != null){
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

    }
}
