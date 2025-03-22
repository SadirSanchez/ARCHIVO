<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{

    public function index()
    {
        return Inertia::render('Users/Index');
    }


    public function getUsers()
    {
        $users = User::all();

        return $users;
    }


    /**
     * Eliminar un usuario.
     */
    public function destroy($id)
    {
        // Buscar el usuario por ID
        $user = User::findOrFail($id);

        // Eliminar el usuario
        $user->delete();

        // Redirigir a la lista de usuarios con un mensaje de éxito
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
