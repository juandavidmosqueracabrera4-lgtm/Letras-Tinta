<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    // Muestra la lista de usuarios
    public function index()
    {
        $users = User::with('role')->get();

        return view('users.index', ['users' => $users]);
    }

    // Muestra el formulario para crear un usuario
    public function create()
    {
        $roles = Role::all();

        return view('users.create', ['roles' => $roles]);
    }

    // Guarda un usuario nuevo aplicando las reglas de negocio
    public function store(Request $request)
    {
        // Valida los datos recibidos
        Validator::make($request->all(),
        [
            'name'     => 'required|max:100',
            'email'    => 'required|email|unique:users,email',
            'document' => 'required|max:20|unique:users,document',
            'role_id'  => 'required|exists:roles,id',
            'password' => 'required|string|min:6',
        ],
        [
            'name.required'      => 'The name is required',
            'name.max'           => 'The name cannot exceed :max characters',
            'email.required'     => 'The email is required',
            'email.email'        => 'The email format is invalid',
            'email.unique'       => 'This email is already registered',
            'document.required'  => 'The document is required',
            'document.max'       => 'The document cannot exceed :max characters',
            'document.unique'    => 'This document is already registered',
            'role_id.required'   => 'The role is required',
            'role_id.exists'     => 'The selected role does not exist',
            'password.required'  => 'The password is required'
        ])->validate();

        try {

            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->document = $request->document;
            $user->role_id  = $request->role_id;

            // Regla de negocio: la contraseña inicial es el documento encriptado
            $user->password = Hash::make($request->password);

            // Regla de negocio: el correo se verifica al crear el usuario por un administrador
            $user->email_verified_at = now();

            $user->save();

            Session::flash('message', ['content' => 'User created successfully', 'type' => 'success']);
            return redirect()->route('users.index');

        } catch (Exception $ex) {

            Log::error($ex);
            Session::flash('message', ['content' => 'An error occurred while creating the user', 'type' => 'error']);
            return redirect()->back();
        }
    }

    // Muestra el formulario para editar un usuario
    public function edit($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            Session::flash('message', ['content' => "The user with ID '$id' does not exist", 'type' => 'error']);
            return redirect()->back();
        }

        $roles = Role::all();

        return view('users.edit', ['user' => $user, 'roles' => $roles]);
    }

    // Actualiza un usuario existente
    public function update(Request $request)
    {
        // Valida los datos recibidos
        Validator::make($request->all(),
        [
            'user_id' => 'required|exists:users,id',
            'name'    => 'required|max:100',
            'email'   => 'required|email|unique:users,email,' . $request->user_id,
            'role_id' => 'required|exists:roles,id',
        ],
        [
            'user_id.required'  => 'The user is required',
            'user_id.exists'    => 'The user does not exist',
            'name.required'     => 'The name is required',
            'name.max'          => 'The name cannot exceed :max characters',
            'email.required'    => 'The email is required',
            'email.email'       => 'The email format is invalid',
            'email.unique'      => 'This email is already registered',
            'role_id.required'  => 'The role is required',
            'role_id.exists'    => 'The selected role does not exist',
        ])->validate();

        try {

            $user = User::find($request->user_id);
            $user->name    = $request->name;
            $user->email   = $request->email;
            $user->role_id = $request->role_id;
            $user->save();

            Session::flash('message', ['content' => 'User updated successfully', 'type' => 'success']);
            return redirect()->route('users.index');

        } catch (Exception $ex) {

            Log::error($ex);
            Session::flash('message', ['content' => 'An error occurred while updating the user', 'type' => 'error']);
            return redirect()->back();
        }
    }

    // Elimina un usuario
    public function destroy($id)
    {
        try {

            $user = User::find($id);

            if (empty($user)) {
                Session::flash('message', ['content' => "The user with ID '$id' does not exist", 'type' => 'error']);
                return redirect()->back();
            }

            $user->delete();

            Session::flash('message', ['content' => 'User deleted successfully', 'type' => 'success']);
            return redirect()->route('users.index');

        } catch (Exception $ex) {

            Log::error($ex);
            Session::flash('message', ['content' => 'An error occurred while deleting the user', 'type' => 'error']);
            return redirect()->back();
        }
    }
}
