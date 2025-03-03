<?php

namespace App\Http\Controllers;

use App\Events\TaskCreatedEvent;
use App\Events\TaskDeletedEvent;
use App\Events\TaskUpdatedEvent;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Task::class);

        $tasks = TaskResource::collection(Task::query()->paginate());

        return Inertia::render('Task/Index', [
            'tasks' => $tasks,
        ]);
    }

    public function store(TaskRequest $request)
    {
        $this->authorize('create', Task::class);

        $validated = $request->validated();

        $task = Task::create($validated);

        new TaskCreatedEvent($task);

        return to_route('task.index')->with('success', 'Task created.');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return new TaskResource($task);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

        new TaskUpdatedEvent($task);

        return to_route('task.index')->with('success', 'Task updated.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        new TaskDeletedEvent($task);

       $task->delete();

        return back()->with('success', 'Task deleted.');
    }
}
