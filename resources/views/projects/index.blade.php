@extends('layouts.app')

@section('content')

    <header class="flex mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-gray-500 text-lg font-normal">My Projects</h2>
            <a href="{{ url('/projects/create') }}" class="button">
                Create New Project
            </a>
        </div>
    </header>

    <main class="lg:flex flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include("projects.card")
            </div>
        @empty
        <div>No projects found!</div>
        @endforelse
    </main>

@endsection
