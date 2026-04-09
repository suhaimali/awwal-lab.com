@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #1f1140;">Equipment Matrix</h2>
            <p class="text-muted mb-0">Track physical assets and hardware status across all labs.</p>
        </div>
        @if(auth()->user()->role == 'admin')
        <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            + Register New Equipment
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead style="background: rgba(240, 244, 248, 0.5);">
                        <tr>
                            <th class="border-top-0 ps-4">Asset ID</th>
                            <th class="border-top-0">Item Nomenclature</th>
                            <th class="border-top-0">Assigned Facility</th>
                            <th class="border-top-0 text-center">Operational Status</th>
                            <th class="border-top-0 text-end pe-4">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipment as $item)
                        <tr>
                            <td class="ps-4 fw-bold" style="color: #9333ea;">#EQ{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon me-3" style="width: 40px; height: 40px; font-size: 16px; background: rgba(217, 70, 239, 0.1); color: #d946ef;">
                                        EQ
                                    </div>
                                    <div class="fw-bold text-dark">{{ $item->name }}</div>
                                </div>
                            </td>
                            <td class="text-muted">
                                <span class="badge bg-secondary text-dark px-2 py-1" style="background: #e2e8f0 !important;">{{ optional($item->lab)->lab_name ?? 'Unassigned' }}</span>
                            </td>
                            <td class="text-center">
                                @if(strtolower($item->status) == 'available' || strtolower($item->status) == 'operational' || strtolower($item->status) == 'active')
                                    <span class="badge bg-success text-uppercase"><i class="fa fa-check-circle me-1"></i> Active</span>
                                @elseif(strtolower($item->status) == 'maintenance' || strtolower($item->status) == 'repair')
                                    <span class="badge bg-warning text-uppercase text-dark"><i class="fa fa-wrench me-1"></i> Under Repair</span>
                                @else
                                    <span class="badge bg-secondary text-uppercase">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if(auth()->user()->role == 'admin')
                                    <a href="{{ route('admin.equipment.edit', $item->id) }}" class="btn btn-sm btn-warning text-white px-3 me-2" style="border-radius: 8px;">Update</a>
                                    <form action="{{ route('admin.equipment.destroy', $item->id) }}" method="POST" class="d-inline">      
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3 shadow-none" style="border-radius: 8px;">Decline Asset</button>
                                    </form>
                                @elseif(auth()->user()->role == 'staff')
                                    <a href="{{ route('staff.equipment.edit', $item->id) }}" class="btn btn-sm btn-info text-white px-3" style="border-radius: 8px;">Change Status</a>      
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($equipment->isEmpty())
            <div class="text-center p-5 text-muted">
                No equipment records found in the database.
            </div>
            @endif
        </div>
    </div>
