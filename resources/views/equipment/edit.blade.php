@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Equipment</h1>
    <form action="{{ auth()->user()->role == 'admin' ? route('admin.equipment.update', $equipment->id) : route('staff.equipment.update', $equipment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Equipment Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $equipment->name }}" required {{ auth()->user()->role == 'staff' ? 'disabled' : '' }}>
        </div>
        <div class="mb-3">
            <label for="lab_id" class="form-label">Lab</label>
            <select class="form-control" id="lab_id" name="lab_id" required {{ auth()->user()->role == 'staff' ? 'disabled' : '' }}>
                @foreach($labs as $lab)
                <option value="{{ $lab->id }}" {{ $equipment->lab_id == $lab->id ? 'selected' : '' }}>{{ $lab->lab_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="{{ $equipment->status }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
