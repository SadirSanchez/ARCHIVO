<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Mostrar la tabla con todos los usuarios.
     */
    public function index()
    {
        // Obtener todos los usuarios ordenados por fecha de creación
        $users = User::select('id', 'name', 'email', 'created_at')->orderBy('created_at', 'desc')->get();

        // Retornar la vista de Inertia con los datos de usuarios
        return Inertia::render('Users/Index', ['users' => $users]);
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
