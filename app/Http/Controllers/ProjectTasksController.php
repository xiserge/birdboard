<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project, Request $request)
    {
        if(auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        $validated = $request->validate([
            'body' => 'required',
        ]);

        $project->addTask($validated['body']);

        return redirect($project->path());
    }
}
