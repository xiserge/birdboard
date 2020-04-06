<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project, Request $request)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        $validated = $request->validate([
            'body' => 'required',
        ]);

        $project->addTask($validated['body']);

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        $task->update([
            'body' => \request('body'),
            'completed' => \request()->has('completed'),
        ]);

        return redirect($project->path());
    }
}
