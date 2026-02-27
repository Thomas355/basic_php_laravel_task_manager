<!DOCTYPE html>
<html>
<head>
    <title>Task Manager - Projects</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; line-height: 1.6; }
        .project-item { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 10px; 
            border-bottom: 1px solid #eee; 
        }
        .error { color: red; font-size: 0.8em; }
        .nav-header { display: flex; justify-content: space-between; align-items: center; }
        button { cursor: pointer; }
    </style>
</head>
<body>

<div class="nav-header">
    <h1>My Projects</h1>
    <a href="{{ route('users.index') }}">Switch User</a>
</div>

{{-- 1. Create Project Form --}}
<form method="POST" action="{{ route('projects.store') }}">
    @csrf
    <input type="text" name="name" placeholder="New Project Name" required>
    <button type="submit">Create Project</button>
</form>

{{-- Display Validation Errors (e.g., if project name is taken) --}}
@error('name')
    <p class="error">{{ $message }}</p>
@enderror

<hr>

{{-- 2. Project List --}}
@if($projects->isEmpty())
    <p>No projects yet. Create one above!</p>
@else
    @foreach($projects as $project)
        <div class="project-item">
            <a href="{{ route('projects.show', $project) }}" style="font-weight: bold; text-decoration: none; color: #007bff;">
                {{ $project->name }} 
                <span style="font-weight: normal; color: #666;">
                    ({{ $project->tasks_count ?? $project->tasks->count() }} tasks)
                </span>
            </a>

            <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Are you sure? This will delete all tasks in this project.');">
                @csrf
                @method('DELETE')
                <button type="submit" style="color: #dc3545; border: 1px solid #dc3545; background: white; border-radius: 3px;">
                    Delete
                </button>
            </form>
        </div>
    @endforeach
@endif

</body>
</html>