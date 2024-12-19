<?php

namespace App\Http\Controllers;


use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();  // Obtiene todos los usuarios

        return Inertia::render('Users/Index', [
            'users' => $users
        ]);
    }
}
