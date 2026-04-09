
<x-app-layout>
    </style>

    <div id="loadingOverlay" style="display:flex;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.7);z-index:9999;align-items:center;justify-content:center;">
        <div style="text-align:center;">
            <span class="spinner-border text-info" style="width:3rem;height:3rem;" role="status" aria-hidden="true"></span>
            <div class="mt-3 fw-bold text-info" style="font-size:1.2rem;">Loading, please wait...</div>
        </div>
    </div>
    <script>
    window.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }, 2000);
    });
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold text-primary" style="font-size:1.2rem;">Total Patients: {{ $totalPatients ?? 0 }}</div>
                        </div>
                        <a href="{{ route('patients.create') }}" class="btn btn-gradient-primary shadow"><i class="fa fa-user-plus me-2"></i> Add Patient</a>
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
                    <div class="mb-4">
                        <h3 class="font-semibold mb-2">Recent Patients</h3>
                        <ul>
                            @forelse($recentPatients ?? [] as $patient)
                                <li class="border-b py-1 flex justify-between">
                                    <span>{{ $patient->name }} ({{ $patient->visit_date }})</span>
                                    <a href="{{ route('patients.show', $patient) }}" class="text-blue-600">View</a>
                                </li>
                            @empty
                                <li>No recent patients.</li>
                            @endforelse
                        </ul>
                    </div>
                    <nav class="flex gap-4 mt-6">
                        <a href="{{ route('patients.dashboard') }}" class="text-blue-700">Dashboard</a>
                        <a href="{{ route('patients.index') }}" class="text-blue-700">Patient List</a>
                        <a href="{{ route('patients.create') }}" class="text-blue-700">Add Patient</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
