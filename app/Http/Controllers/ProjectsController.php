<?php

namespace App\Http\Controllers;

use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function store()
    {
        $validated = request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        auth()->user()->projects()->create($validated);
        return redirect('/projects');
    }

    public function view(Project $project)
    {
        if(auth()->user()->isNot($project->owner)) {
            abort(403);
        }
        return view('projects.view', compact('project'));
    }
}
