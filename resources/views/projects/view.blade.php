@extends('layouts.app')

@section('content')

    <header class="flex mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-500 text-lg font-normal">
                <a href="/projects">My Projects</a>
                /
                <a href="{{ $project->path() }}">{{ $project->title }}</a>
            </p>
            <a href="{{ url('/projects/create') }}" class="button">
                Create New Project
            </a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="mb-3 text-gray-500 font-normal text-lg">Tasks</h2>

                    <div class="card mb-3">Lorem ipsum.</div>
                    <div class="card mb-3">Lorem ipsum.</div>
                    <div class="card mb-3">Lorem ipsum.</div>
                    <div class="card">Lorem ipsum.</div>
                </div>

                <div>
                    <h2 class="mb-3 text-gray-500 font-normal text-lg">General Notes</h2>

                    <textarea class="card w-full" style="min-height: 200px">Lorem ipsum.</textarea>
                </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include("projects.card")
            </div>
        </div>
    </main>

@endsection
