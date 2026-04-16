@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background: linear-gradient(135deg, #a78bfa 0%, #06b6d4 100%);">
    <div class="bg-white rounded-4 shadow-lg p-4 p-md-5 w-100" style="max-width: 480px;">
        <div class="mb-4">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary mb-3 fw-bold">
                <i class="fa fa-arrow-left me-1"></i> Back to Users
            </a>
            <div class="text-center">
                <i class="fa-solid fa-user-plus fa-3x text-primary"></i>
                <h1 class="fw-bold mb-2" style="color:#7c3aed;">Add User</h1>
            </div>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control border-primary shadow-none" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control border-primary shadow-none" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control border-primary shadow-none" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control border-primary shadow-none" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control border-primary shadow-none" id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold py-2" style="background: linear-gradient(90deg,#06b6d4,#a78bfa); border:none;">Add User</button>
        </form>
    </div>
</div>
<style>
@media (max-width: 600px), (max-height: 500px) {
    .rounded-4 { border-radius: 1.2rem !important; }
    .shadow-lg { box-shadow: 0 2px 16px rgba(6,182,212,0.18) !important; }
    .p-md-5 { padding: 1.2rem !important; }
    .p-4 { padding: 0.7rem !important; }
    .w-100 { max-width: 98vw !important; }
}
</style>
@endsection
