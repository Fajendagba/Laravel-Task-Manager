<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with('tasks')->get();
        $selectedProject = $request->get('project');

        $tasks = Task::with('project')
            ->forProject($selectedProject)
            ->orderBy('priority')
            ->get();

        if ($request->ajax()) {
            return view('tasks.partials.task-list', compact('tasks'))->render();
        }

        return view('tasks.index', compact('tasks', 'projects', 'selectedProject'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id'
        ]);

        $task = Task::create($validated);

        if ($request->ajax()) {
            $task->load('project');
            return response()->json([
                'success' => true,
                'task' => $task,
                'html' => view('tasks.partials.task-item', ['task' => $task])->render()
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully');
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id'
        ]);

        $task->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'task' => $task->fresh('project')
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully');
    }

    public function destroy(Request $request, Task $task)
    {
        $task->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully');
    }

    public function reorder(Request $request)
    {
        $taskIds = $request->get('task_ids', []);

        foreach ($taskIds as $index => $taskId) {
            Task::where('id', $taskId)->update(['priority' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}