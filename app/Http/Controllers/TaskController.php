<?php

  namespace App\Http\Controllers;

  use App\Models\Task;
  use App\Models\Category;
  use App\Http\Requests\TaskRequest;
  use Illuminate\Http\RedirectResponse;
  use Illuminate\View\View;

  class TaskController extends Controller
  {
      // Show the task dashboard
      public function index(): View
    {
        $tasks = Task::with('category')->orderBy('due_date')->get();
        $urgentCount = Task::where('status', 'pending')->where('due_date', '<', now())->count();
        $pending = $tasks->where('status', 'pending');
        $completed = $tasks->where('status', 'completed');
        $categories = Category::all();

        return view('tasks.index', compact('tasks', 'pending', 'completed', 'urgentCount', 'categories'));
    }

      public function create(): View
      {
          $categories = Category::all();
          return view('tasks.create', compact('categories'));
      }

      public function store(TaskRequest $request): RedirectResponse
      {
          Task::create($request->validated());

          return redirect()
              ->route('tasks.index')
              ->with('success', 'Task created successfully.');
      }

      public function edit(Task $task): View
      {
          $categories = Category::all();
          return view('tasks.edit', compact('task', 'categories'));
      }

      public function update(TaskRequest $request, Task $task): RedirectResponse
      {
          $task->update($request->validated());

          return redirect()
              ->route('tasks.index')
              ->with('success', 'Task updated successfully.');
      }

      public function destroy(Task $task): RedirectResponse
      {
          $task->delete();

          return redirect()
              ->route('tasks.index')
              ->with('success', 'Task deleted successfully.');
      }

      public function toggleStatus(Task $task): RedirectResponse
      {
          $task->update([
              'status' => $task->status === 'pending' ? 'completed' : 'pending',
          ]);

          return redirect()
              ->route('tasks.index')
              ->with('success', 'Task status updated.');
      }
  }