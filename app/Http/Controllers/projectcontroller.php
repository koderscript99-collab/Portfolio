<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'language' => ['required', 'string', 'max:100'],
            'expiry_date' => ['nullable', 'date'],
            'host_type' => ['nullable', 'string', 'max:100'],
            'host_provider' => ['nullable', 'string', 'max:100'],
            'url' => ['nullable', 'url'],
            'status' => ['required', 'in:started,in_progress,done'],
        ]);

        Project::create($validated);

        return back()->with('success', 'Project assigned successfully.');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'language' => ['required', 'string', 'max:100'],
            'expiry_date' => ['nullable', 'date'],
            'host_type' => ['nullable', 'string', 'max:100'],
            'host_provider' => ['nullable', 'string', 'max:100'],
            'url' => ['nullable', 'url'],
            'status' => ['required', 'in:started,in_progress,done'],
        ]);

        $project->update($validated);

        return back()->with('success', 'Project updated.');
    }
}