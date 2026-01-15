@extends('layouts.admin')

@section('title', 'Create Ticket')

@section('styles')
<style>
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-cancel {
        background: #e2e8f0;
        border: none;
        border-radius: 8px;
        padding: 12px 30px;
        color: #4a5568;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-cancel:hover {
        background: #cbd5e0;
        color: #2d3748;
    }
</style>
@endsection

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
</nav>

<!-- Page Header -->
<div class="page-header">
    <h2>Create New Ticket</h2>
    <p>Add a new ticket to the system</p>
</div>

<!-- Form Card -->
<div class="content-card">
    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="ticket_no" class="form-label">Ticket No <span class="text-danger">*</span></label>
                <input type="text"
                       class="form-control @error('ticket_no') is-invalid @enderror"
                       id="ticket_no"
                       name="ticket_no"
                       value="{{ old('ticket_no') }}"
                       required
                       placeholder="Enter ticket number">
                @error('ticket_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="reference_no" class="form-label">Reference No</label>
                <input type="number"
                       class="form-control @error('reference_no') is-invalid @enderror"
                       id="reference_no"
                       name="reference_no"
                       value="{{ old('reference_no') }}"
                       placeholder="Enter reference number (optional)">
                @error('reference_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="sold_status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select @error('sold_status') is-invalid @enderror"
                        id="sold_status"
                        name="sold_status"
                        required>
                    <option value="0" {{ old('sold_status', 0) == 0 ? 'selected' : '' }}>Unsold</option>
                    <option value="1" {{ old('sold_status') == 1 ? 'selected' : '' }}>Sold</option>
                </select>
                @error('sold_status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="sold_date" class="form-label">Sold Date</label>
                <input type="datetime-local"
                       class="form-control @error('sold_date') is-invalid @enderror"
                       id="sold_date"
                       name="sold_date"
                       value="{{ old('sold_date') }}">
                @error('sold_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-submit">
                💾 Create Ticket
            </button>
            <a href="{{ route('tickets.index') }}" class="btn btn-cancel">
                ✖ Cancel
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Auto-enable/disable sold_date based on sold_status
    document.getElementById('sold_status').addEventListener('change', function() {
        const soldDate = document.getElementById('sold_date');
        if (this.value == '1') {
            soldDate.removeAttribute('disabled');
            if (!soldDate.value) {
                // Set current datetime
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                soldDate.value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
        } else {
            soldDate.value = '';
            soldDate.setAttribute('disabled', 'disabled');
        }
    });

    // Trigger on page load
    document.getElementById('sold_status').dispatchEvent(new Event('change'));
</script>
@endsection
