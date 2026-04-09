@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Lab</h1>
    <form action="{{ route('admin.labs.update', $lab->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="lab_name" class="form-label">Lab Name</label>
            <input type="text" class="form-control" id="lab_name" name="lab_name" value="{{ $lab->lab_name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $lab->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
