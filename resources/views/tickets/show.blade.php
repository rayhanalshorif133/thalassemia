@extends('layouts.admin')

@section('title', 'View Ticket')

@section('styles')
<style>
    .detail-row {
        padding: 15px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #718096;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 16px;
        color: #2d3748;
        font-weight: 500;
    }

    .btn-edit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-back {
        background: #e2e8f0;
        border: none;
        border-radius: 8px;
        padding: 10px 25px;
        color: #4a5568;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: #cbd5e0;
        color: #2d3748;
    }

    .btn-delete {
        background: #ef4444;
        border: none;
        border-radius: 8px;
        padding: 10px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
        color: white;
    }
</style>
@endsection

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></li>
        <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
</nav>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2>Ticket Details</h2>
            <p>View ticket information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-edit">
                ✏️ Edit
            </a>
            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">
                    🗑️ Delete
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Ticket Details Card -->
<div class="content-card">
    <h5 class="mb-4">Ticket Information</h5>

    <div class="row">
        <div class="col-md-6">
            <div class="detail-row">
                <div class="detail-label">Ticket No</div>
                <div class="detail-value">{{ $ticket->ticket_no }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Reference No</div>
                <div class="detail-value">{{ $ticket->reference_no ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <span class="badge {{ $ticket->status_badge }} fs-6">
                        {{ $ticket->status_label }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="detail-row">
                <div class="detail-label">Sold Date</div>
                <div class="detail-value">
                    {{ $ticket->sold_date ? $ticket->sold_date->format('F d, Y h:i A') : 'N/A' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Created At</div>
                <div class="detail-value">
                    {{ $ticket->created_at->format('F d, Y h:i A') }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Updated At</div>
                <div class="detail-value">
                    {{ $ticket->updated_at->format('F d, Y h:i A') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Information Card -->
<div class="content-card">
    <h5 class="mb-4">User Information</h5>

    <div class="row">
        <div class="col-md-6">
            <div class="detail-row">
                <div class="detail-label">Created By</div>
                <div class="detail-value">
                    {{ $ticket->creator ? $ticket->creator->name : 'N/A' }}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="detail-row">
                <div class="detail-label">Updated By</div>
                <div class="detail-value">
                    {{ $ticket->updater ? $ticket->updater->name : 'N/A' }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="mt-3">
    <a href="{{ route('tickets.index') }}" class="btn btn-back">
        ← Back to List
    </a>
</div>
@endsection
