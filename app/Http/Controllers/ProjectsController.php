<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function store()
    {
        $validated = \request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $validated['owner_id'] = Auth::id();
        Project::create($validated);
        return redirect('/projects');
    }

    public function view(Project $project)
    {
        return view('projects.view', compact('project'));
    }
}
