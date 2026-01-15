@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <style>
        /* Stats Cards */
        .stats-row {
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }

        .stat-icon.purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .stat-icon.green {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .stat-label {
            font-size: 13px;
            color: #718096;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }

        .stat-change {
            font-size: 13px;
            margin-top: 8px;
        }

        .stat-change.up {
            color: #48bb78;
        }

        .stat-change.down {
            color: #f56565;
        }

        /* Alert Success */
        .alert-success {
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            padding: 15px 20px;
            font-weight: 500;
        }

        /* Quick Action Buttons */
        .btn-quick-action {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-quick-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-outline-quick {
            border: 2px solid #667eea;
            border-radius: 10px;
            padding: 12px;
            color: #667eea;
            font-weight: 600;
            background: white;
            transition: all 0.3s;
        }

        .btn-outline-quick:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        /* Table Styles */
        .table {
            border-collapse: separate;
            border-spacing: 0;
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
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        @media (max-width: 768px) {
            .stat-value {
                font-size: 24px;
            }
        }


        
    </style>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <h2>Dashboard</h2>
        <p>Welcome back! Here's what's happening today.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row stats-row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <span>🎫</span>
                </div>
                <div class="stat-label">Sold Today</div>
                <h3 class="stat-value">{{ $todayCount ?? 0 }}</h3>
                <div class="stat-change up">
                    <span>আজকের বিক্রি</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <span>🗓️</span>
                </div>
                <div class="stat-label">Sold Yesterday</div>
                <h3 class="stat-value">{{ $yesterdayCount ?? 0 }}</h3>
                <div class="stat-change">
                    <span>গতকালের বিক্রি</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon green">
                    <span>✅</span>
                </div>
                <div class="stat-label">Total Sold</div>
                <h3 class="stat-value">{{ $totalSold ?? 0 }}</h3>
                <div class="stat-change up">
                    <span>মোট বিক্রি</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <span>🎯</span>
                </div>
                <div class="stat-label">Remaining Target</div>
                <h3 class="stat-value">{{ 500000 - ($totalSold ?? 0) }}</h3>
                <div class="stat-change down">
                    <span>Out of 5,00,000</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Daily sales trend</h5>
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');

        // কন্ট্রোলার থেকে আসা ডাটা রিসিভ করা
        const labels = @json($labels);
        const data = @json($data);

        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tickets Sold',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

@endsection
