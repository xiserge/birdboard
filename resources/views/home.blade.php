@extends('layouts.app')

@section('assets')
    <link href="{{ asset('css/home.index.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="flex-center position-ref full-height">
        <div class="content">
            <a href="/projects">My Projects</a>
        </div>
    </div>

@endsection
