<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Store task under a project, prevents junk data 
    public function store(Request $request, Project $project)
    {

        $request->validate([
            'title' => 'required|string|max:255|unique:tasks,title,NULL,id,project_id,' . $project->id,
        ]);

        $project->tasks()->create([
            'title' => $request->title
        ]);

        return back();
    }

    // Mark task complete
    public function update(Task $task)
    {
        $task->update([
            'completed' => !$task->completed
        ]);

        return back();
    }

    // Delete task
    public function destroy(Task $task)
    {
        $task->delete();
        return back();
    }

    /**
     * Remove all completed tasks for a specific project.
     */
    public function deleteCompleted(Project $project)
    {
        // 1. Find all tasks where completed is true for THIS project
        // 2. Delete them in one database query
        $project->tasks()->where('completed', true)->delete();

        // 3. Send the user back with a success message
        return back()->with('message', 'Completed tasks cleared!');
    }
}