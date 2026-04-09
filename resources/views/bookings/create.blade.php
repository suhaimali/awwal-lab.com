@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Book a Lab</h1>
    <form action="{{ route('student.bookings.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="lab_id" class="form-label">Lab</label>
            <select class="form-control" id="lab_id" name="lab_id" required>
                @foreach($labs as $lab)
                <option value="{{ $lab->id }}">{{ $lab->lab_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>
        <button type="submit" class="btn btn-primary">Book Now</button>
    </form>
</div>
@endsection
