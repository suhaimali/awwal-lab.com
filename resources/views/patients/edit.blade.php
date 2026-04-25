@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4 max-w-lg">
    <div class="mb-3">
        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i> Back</a>
    </div>
    <h1 class="text-2xl font-bold mb-2">Edit Patient</h1>
    <div class="mb-3 text-muted">Update patient information and vitals</div>
    <form method="POST" action="{{ route('patients.update', $patient) }}" class="bg-white rounded shadow p-4">
        @csrf
        @method('PUT')
        <h5 class="fw-bold mb-3 text-primary">Basic Information</h5>
        <table class="table table-bordered mb-4">
            <tr>
                <th style="width: 40%">Full Name</th>
                <td>
                    <input type="text" name="name" value="{{ old('name', $patient->name) }}" class="form-control" required />
                    @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                </td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td>
                    <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" class="form-control" required />
                    @error('phone')<div class="text-danger small">{{ $message }}</div>@enderror
                </td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>
                    <select name="gender" class="form-select" required>
                        <option value="">Select</option>
                        <option value="Male" @if(old('gender', $patient->gender)=='Male') selected @endif>Male</option>
                        <option value="Female" @if(old('gender', $patient->gender)=='Female') selected @endif>Female</option>
                        <option value="Other" @if(old('gender', $patient->gender)=='Other') selected @endif>Other</option>
                    </select>
                    @error('gender')<div class="text-danger small">{{ $message }}</div>@enderror
                </td>
            </tr>
            <tr>
                <th>Age</th>
                <td>
                    <input type="number" name="age" value="{{ old('age', $patient->age) }}" class="form-control" required />
                    @error('age')<div class="text-danger small">{{ $message }}</div>@enderror
                </td>
            </tr>
            <tr>
                <th>Address</th>
                <td>
                    <input type="text" name="address" value="{{ old('address', $patient->address) }}" class="form-control" required />
                    @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
                </td>
            </tr>
            <tr>
                <th>Reference Doctor</th>
                <td>
                    <input type="text" name="reference_dr_name" value="{{ old('reference_dr_name', $patient->reference_dr_name) }}" class="form-control" />
                    @error('reference_dr_name')<div class="text-danger small">{{ $message }}</div>@enderror
                </td>
            </tr>
            <tr>
                <th>Visit Date</th>
                <td>
                    <input type="date" name="visit_date" value="{{ old('visit_date', $patient->visit_date) }}" class="form-control" required />
                    @error('visit_date')<div class="text-danger small">{{ $message }}</div>@enderror
                </td>
            </tr>
        </table>
        <button type="submit" style="background:#6366f1;color:#fff;padding:8px 24px;border:none;border-radius:4px;cursor:pointer;">Update</button>
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