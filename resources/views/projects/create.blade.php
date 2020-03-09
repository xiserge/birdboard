@extends('layouts.app')

@section('content')
    <h1>Creating project form</h1>
    <form action="{{ url('/projects') }}" method="POST">
        @csrf

        <div class="form-row">
            <label class="col-2">Title</label>
            <input name="title" placeholder="title" class="form-control col">
        </div>

        <div class="form-row">
            <label class="col-2">Description</label>
            <input class="form-control col" name="description" placeholder="descrtiption">
        </div>

        <button type="submit" class="btn btn-primary">Create project</button>
    </form>

@endsection
