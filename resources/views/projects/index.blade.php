@extends('layouts.app')

@section('content')

    <div class="flex items-center mb-3">
        <h1 class="mr-auto">My Projects</h1>
        <a href="{{ url('/projects/create') }}" class="btn btn-primary">
            Create New Project
        </a>
    </div>

    <div class="flex">
        @forelse($projects as $project)
        <div class="bg-white shadow rounded mr-4 p-5 w-1/3 " style="height: 200px">
            <h3 class="font-normal text-xl py-4">{{ $project->title }}</h3>
            <div class="text-gray-500">{{ Str::limit($project->description, 100) }}</div>
        </div>
        @empty
        <div>No projects found!</div>
        @endforelse
    </div>

@endsection
