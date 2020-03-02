@extends('layouts.app')

@section('content')
<ul>
    <h1>{{ $project->title }}</h1>
    <div>{{ $project->description }}</div>
</ul>
@endsection
