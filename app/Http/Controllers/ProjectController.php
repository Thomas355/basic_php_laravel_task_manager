<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Show all projects
    public function index()
    {
        $userId = session('active_user');

        if (!$userId) {
            return redirect()->route('users.index');
        }

        $projects = Project::where('user_id', $userId)->get();

        return view('projects.index', compact('projects'));
    }

    // Store new project

    public function store(Request $request)
    {
       
        $userId = session('active_user');

        // ensure name is of proper length and exists, and unique for the user
        $request->validate([
            'name' => 'required|string|max:255|unique:projects,name,NULL,id,user_id,' . $userId
        ]);


        Project::create([
            'name' => $request->name,
            'user_id' => $userId
        ]);

        return redirect()->route('projects.index');
    }

    

    // Show single project with tasks
    public function show(Project $project)
    {
        $project->load('tasks');
        return view('projects.show', compact('project'));
    }

    // Delete project
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index');
    }
}
