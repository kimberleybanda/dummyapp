<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(Request $request, User $user, Task $task)
    {
        return auth()->user()->id === $task->user_id;
    }

    public function view(Request $request, User $user, Task $task)
    {
    }

    public function create(Request $request, User $user, Task $task)
    {
    }

    public function update(Request $request, User $user, Task $task)
    {
    }

    public function delete(Request $request, User $user, Task $task)
    {
    }

    public function restore(Request $request, User $user, Task $task)
    {
    }

    public function forceDelete(Request $request, User $user, Task $task)
    {
    }
}
