@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Equipment</h1>
    <form action="{{ route('admin.equipment.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Equipment Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="lab_id" class="form-label">Lab</label>
            <select class="form-control" id="lab_id" name="lab_id" required>
                @foreach($labs as $lab)
                <option value="{{ $lab->id }}">{{ $lab->lab_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="available" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
