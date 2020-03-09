@extends('layouts.app')

@section('content')
    <h1>Creating project form</h1>
    <form action="{{ url('/projects') }}" method="POST">
        @csrf

        <div class="form-group row">
            <label class="col-2 col-form-label">Title</label>
            <input name="title" placeholder="title" class="form-control col">
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">Description</label>
            <input class="form-control col" name="description" placeholder="descrtiption">
        </div>

        <div class="form-group row">
            <button type="submit" class="btn btn-primary">Create project</button>
            <a href="{{ url('/projects') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

@endsection
