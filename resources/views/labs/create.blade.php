@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Lab</h1>
    <form action="{{ route('admin.labs.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="lab_name" class="form-label">Lab Name</label>
            <input type="text" class="form-control" id="lab_name" name="lab_name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
