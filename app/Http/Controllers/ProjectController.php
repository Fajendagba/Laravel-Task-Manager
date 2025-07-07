<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:projects,name'
        ]);

        $project = Project::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'project' => $project
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Project created successfully');
    }
}