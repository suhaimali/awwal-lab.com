@extends('layouts.app')
@section('content')
<div class="container py-4" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">Add Patient</h1>
        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i> Back</a>
    </div>
    <form method="POST" action="{{ route('patients.store') }}" class="row g-3 bg-white p-4 rounded shadow">
        @csrf
        <div class="col-md-12">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control border-primary" required />
            @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Age</label>
            <input type="number" name="age" value="{{ old('age') }}" class="form-control border-info" required />
            @error('age')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select border-info" required>
                <option value="">Select</option>
                <option value="Male" @if(old('gender')=='Male') selected @endif>Male</option>
                <option value="Female" @if(old('gender')=='Female') selected @endif>Female</option>
                <option value="Other" @if(old('gender')=='Other') selected @endif>Other</option>
            </select>
            @error('gender')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control border-success" required />
            @error('phone')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Address</label>
            <input type="text" name="address" value="{{ old('address') }}" class="form-control border-success" required />
            @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Visit Date</label>
            <input type="date" name="visit_date" value="{{ old('visit_date') }}" class="form-control border-warning" required />
            @error('visit_date')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-12">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control border-secondary">{{ old('notes') }}</textarea>
            @error('notes')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-gradient-primary px-4" type="submit"><i class="fa fa-save me-1"></i> Save</button>
        </div>
    </form>
</div>
<style>
.btn-gradient-primary {
    background: linear-gradient(90deg,#a78bfa,#f472b6);
    color: #fff;
    border: none;
}
.btn-gradient-primary:hover {
    background: linear-gradient(90deg,#f472b6,#a78bfa);
    color: #fff;
}
</style>
@endsection