<!DOCTYPE html>
<html>
<head>
    <title>Task Manager - Select User</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 600px; 
            margin: 40px auto; 
            line-height: 1.6; 
        }
        .user-item { 
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
    <h1>Select User</h1>
</div>

{{-- Existing Users --}}
@if($users->isEmpty())
    <p>No users yet. Create one below!</p>
@else
    @foreach($users as $user)
        <div class="user-item">
            <form method="POST" action="{{ route('users.select', $user) }}">
                @csrf
                <button type="submit" style="background: none; border: none; color: #007bff; font-weight: bold;">
                    {{ $user->name }}
                </button>
            </form>
        </div>
    @endforeach
@endif

<hr>

{{-- Create New User --}}
<h2>Create New User</h2>

<form method="POST" action="{{ route('users.store') }}">
    @csrf

    <input type="text" name="name" placeholder="Enter user name" required>
    <button type="submit">Create User</button>
</form>

{{-- Validation Errors --}}
@error('name')
    <p class="error">{{ $message }}</p>
@enderror

</body>
</html>