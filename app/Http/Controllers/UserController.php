<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    //shows all users 
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    //stores information about the user for registering a new user 
    public function store(Request $request)
    {
        //ensures the name is unique
        $request->validate([
            'name' => 'required|unique:users,name'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password')
        ]);

        session(['active_user' => $user->id]);

        //sends user to projects list 

        return redirect()->route('projects.index');
    }

    //swap between profiles 
    public function select(User $user)
    {
        session(['active_user' => $user->id]);
        return redirect()->route('projects.index');
    }
}