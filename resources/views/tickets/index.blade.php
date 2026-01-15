@extends('layouts.admin')

@section('title', 'Tickets')

@section('styles')
<style>
    .search-box {
        background: white;
        border-radius: 10px;
        padding: 15px 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }

    .search-box input, .search-box select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 15px;
    }

    .btn-add {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-upload {
        background: #10b981;
        border: none;
        border-radius: 8px;
        padding: 10px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-upload:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-export {
        background: #f59e0b;
        border: none;
        border-radius: 8px;
        padding: 10px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-export:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
        color: white;
    }

    .table thead th {
        background: #f8f9fa;
        border: none;
        padding: 15px;
        font-weight: 600;
        color: #2d3748;
        font-size: 14px;
    }

    .table tbody td {
        padding: 15px;
        border-top: 1px solid #e2e8f0;
        font-size: 14px;
        color: #4a5568;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        transition: all 0.3s;
        margin: 0 2px;
    }

    .btn-view {
        background: #e6f2ff;
        color: #667eea;
    }

    .btn-view:hover {
        background: #667eea;
        color: white;
    }

    .btn-edit {
        background: #fff4e6;
        color: #f59e0b;
    }

    .btn-edit:hover {
        background: #f59e0b;
        color: white;
    }

    .btn-delete {
        background: #ffe6e6;
        color: #ef4444;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
    }
</style>
@endsection

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tickets</li>
    </ol>
</nav>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2>Tickets</h2>
            <p>Manage all ticket records</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tickets.upload.form') }}" class="btn btn-upload">
                📤 Upload CSV
            </a>
            <a href="{{ route('tickets.export') }}" class="btn btn-export">
                📥 Export CSV
            </a>
            <a href="{{ route('tickets.create') }}" class="btn btn-add">
                ➕ Add New Ticket
            </a>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('errors') && is_array(session('errors')) && count(session('errors')) > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Some errors occurred:</strong>
        <ul class="mb-0 mt-2">
            @foreach(session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Search & Filter -->
<div class="search-box">
    <form action="{{ route('tickets.index') }}" method="GET">
        <div class="row align-items-center">
            <div class="col-md-6 mb-3 mb-md-0">
                <input type="text" name="search" class="form-control" placeholder="🔍 Search by ticket no or reference no..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Unsold</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Sold</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px;">Search</button>
            </div>
        </div>
    </form>
</div>

<!-- Tickets Table -->
<div class="content-card">
    <h5 class="mb-4">Ticket Records ({{ $tickets->total() }})</h5>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ticket No</th>
                    <th>Reference No</th>
                    <th>Status</th>
                    <th>Sold Date</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <td>{{ $tickets->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $ticket->ticket_no }}</strong></td>
                        <td>{{ $ticket->reference_no ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $ticket->status_badge }}">
                                {{ $ticket->status_label }}
                            </span>
                        </td>
                        <td>{{ $ticket->sold_date ? $ticket->sold_date->format('Y-m-d H:i') : '-' }}</td>
                        <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-action btn-view">View</a>
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-action btn-edit">Edit</a>
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-action btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <p class="text-muted mb-0">No tickets found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($tickets->hasPages())
        <div class="mt-4">
            {{ $tickets->links() }}
        </div>
    @endif
</div>
@endsection
