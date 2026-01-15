@extends('layouts.admin')

@section('title', 'Upload CSV')

@section('styles')
<style>
    .upload-area {
        border: 2px dashed #cbd5e0;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }

    .upload-area.dragover {
        border-color: #667eea;
        background: #e6f2ff;
    }

    .upload-icon {
        font-size: 64px;
        margin-bottom: 20px;
    }

    .file-info {
        margin-top: 20px;
        padding: 15px;
        background: white;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        display: none;
    }

    .file-info.show {
        display: block;
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

    .info-box {
        background: #e6f2ff;
        border-left: 4px solid #667eea;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .sample-csv {
        background: #f8f9fa;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
    }

    .sample-csv code {
        display: block;
        background: white;
        padding: 10px;
        border-radius: 4px;
        margin-top: 10px;
        font-family: monospace;
    }
</style>
@endsection

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></li>
        <li class="breadcrumb-item active" aria-current="page">Upload CSV</li>
    </ol>
</nav>

<!-- Page Header -->
<div class="page-header">
    <h2>Upload CSV File</h2>
    <p>Import multiple tickets from CSV file</p>
</div>

<!-- Error Messages -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Instructions -->
<div class="content-card">
    <div class="info-box">
        <h6 class="mb-2" style="color: #667eea; font-weight: 600;">📋 CSV File Format</h6>
        <p class="mb-0">Your CSV file should contain one column with ticket numbers. The first row will be treated as a header and will be skipped.</p>
    </div>

    <div class="sample-csv">
        <h6 style="font-weight: 600; color: #2d3748;">Sample CSV Format:</h6>
        <code>ticket_no
1231
2345
3456
7890</code>
        <p class="mt-3 mb-0 text-muted"><small><strong>Note:</strong> All tickets will be created with status "Unsold" by default.</small></p>
    </div>
</div>

<!-- Upload Form -->
<div class="content-card">
    <form action="{{ route('tickets.upload.csv') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
        @csrf

        <div class="upload-area" id="uploadArea">
            <div class="upload-icon">📤</div>
            <h5 style="font-weight: 600; color: #2d3748;">Drop your CSV file here</h5>
            <p class="text-muted">or click to browse</p>
            <input type="file"
                   name="csv_file"
                   id="csvFile"
                   accept=".csv,.txt"
                   required
                   style="display: none;">
        </div>

        <div class="file-info" id="fileInfo">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Selected File:</strong>
                    <span id="fileName"></span>
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeFile()">Remove</button>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-submit" id="submitBtn" disabled>
                📤 Upload CSV
            </button>
            <a href="{{ route('tickets.index') }}" class="btn btn-cancel">
                ✖ Cancel
            </a>
        </div>
    </form>
</div>

<!-- Tips -->
<div class="content-card">
    <h6 style="font-weight: 600; color: #2d3748;">💡 Tips:</h6>
    <ul class="mb-0">
        <li>Maximum file size: 2MB</li>
        <li>Accepted formats: .csv, .txt</li>
        <li>Duplicate ticket numbers will be skipped</li>
        <li>Make sure ticket numbers are unique</li>
        <li>You can download existing tickets as CSV for reference</li>
    </ul>
</div>
@endsection

@section('scripts')
<script>
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('csvFile');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const submitBtn = document.getElementById('submitBtn');

    // Click to upload
    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    // File selected
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            fileName.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
            fileInfo.classList.add('show');
            submitBtn.removeAttribute('disabled');
        }
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            const file = files[0];
            fileName.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
            fileInfo.classList.add('show');
            submitBtn.removeAttribute('disabled');
        }
    });

    // Remove file
    function removeFile() {
        fileInput.value = '';
        fileInfo.classList.remove('show');
        submitBtn.setAttribute('disabled', 'disabled');
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
</script>
@endsection
