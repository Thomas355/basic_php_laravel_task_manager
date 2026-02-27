<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->name }} - Tasks</title>
</head>
<body style="font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px;">

    {{-- 1. Header and Navigation --}}
    <a href="{{ route('projects.index') }}" style="text-decoration: none;">← Back to Projects</a>
    <h1>Project: {{ $project->name }}</h1>

    {{-- 2. Flash Messages (Confirmation for actions) --}}
    @if(session('message'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            {{ session('message') }}
        </div>
    @endif

    <hr>

    {{-- 3. Add New Task Form --}}
    <section>
        <h2>Add New Task</h2>
        <form method="POST" action="{{ route('tasks.store', $project) }}" style="display: flex; gap: 10px;">
            @csrf
            <input type="text" name="title" placeholder="Enter task title" required style="flex-grow: 1; padding: 8px;">
            <button type="submit" style="padding: 8px 16px; cursor: pointer;">Add Task</button>
        </form>
        @error('title')
            <p style="color: red; font-size: 0.9em;">{{ $message }}</p>
        @enderror
    </section>

    <hr style="margin: 30px 0;">

    {{-- 4. Task List Actions --}}
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Tasks</h2>
        
        @if($project->tasks->where('completed', true)->count() > 0)
            <form method="POST" action="{{ route('tasks.deleteCompleted', $project) }}">
                @csrf
                @method('DELETE')
                <button type="submit" style="color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; padding: 5px 10px; cursor: pointer; border-radius: 4px;">
                    Clear Completed Tasks
                </button>
            </form>
        @endif
    </div>

    {{-- 5. The Task List --}}
    @if($project->tasks->isEmpty())
        <p style="color: #666; font-style: italic;">No tasks found for this project.</p>
    @else
        <ul style="list-style: none; padding: 0;">
            @foreach($project->tasks as $task)
                <li style="display: flex; align-items: center; justify-content: space-between; padding: 10px; border-bottom: 1px solid #eee;">
                    
                    <div style="display: flex; align-items: center; gap: 15px;">
                        {{-- Toggle Complete Form --}}
                        <form method="POST" action="{{ route('tasks.update', $task) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="cursor: pointer; background: {{ $task->completed ? '#ccc' : '#e1f5fe' }}; border: 1px solid #aaa; padding: 4px 8px; border-radius: 4px;">
                                {{ $task->completed ? 'Undo' : 'Complete' }}
                            </button>
                        </form>

                        {{-- Task Title with conditional styling --}}
                        <span style="{{ $task->completed ? 'text-decoration: line-through; color: #888;' : 'font-weight: bold;' }}">
                            {{ $task->title }}
                        </span>
                    </div>

                    {{-- Delete Individual Task Form --}}
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 0.9em;">
                            [Delete]
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif

</body>
</html>