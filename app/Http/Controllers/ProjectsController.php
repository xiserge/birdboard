<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

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
            'description' => 'required'
        ]);
        Project::create($validated);
        return redirect('/projects');
    }

    public function view(Project $project)
    {
        return view('projects.view', compact('project'));
    }
}
