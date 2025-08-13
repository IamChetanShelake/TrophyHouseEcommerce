@extends('admin.layouts.masterlayout')

@section('title', 'Payment Analytics Dashboard')

@section('content')
<style>
    .dashboard-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
    }
    .dashboard-card.success {
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    }
    .dashboard-card.danger {
        background: linear-gradient(135deg, #f44336 0%, #da190b 100%);
    }
    .dashboard-card.warning {
        background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    }
    .dashboard-card.info {
        background: linear-gradient(135deg, #2196F3 0%, #0b7dda 100%);
    }
    .card-icon {
        font-size: 48px;
        opacity: 0.8;
    }
    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }
    .payments-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    .table th {
        background: #f8f9fa;
        border: none;
        font-weight: 600;
        color: #333;
        padding: 15px;
    }
    .table td {
        border: none;
        padding: 15px;
        vertical-align: middle;
    }
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-paid {
        background: #d4edda;
        color: #155724;
    }
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    .status-failed {
        background: #f8d7da;
        color: #721c24;
    }
    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }
    .btn-filter {
        background: #667eea;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-filter:hover {
        background: #5a6fd8;
        color: white;
        transform: translateY(-2px);
    }
    .btn-export {
        background: #28a745;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-export:hover {
        background: #218838;
        color: white;
        transform: translateY(-2px);
    }
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px 0;
        margin-bottom: 40px;
        border-radius: 15px;
    }
    .mini-chart-item {
        padding: 15px 10px;
        border-radius: 10px;
        background: #f8f9fa;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    .mini-chart-item:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }
    .payment-methods-mini {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
    }
    .method-item {
        padding: 8px 0;
        border-bottom: 1px solid #e9ecef;
    }
    .method-item:last-child {
        border-bottom: none;
    }
    .mini-stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }
    .mini-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    .mini-stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }
    .progress {
        border-radius: 10px;
        background: #e9ecef;
    }
    .progress-bar {
        border-radius: 10px;
    }
</style>

<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="mb-0">
                    <i class="fas fa-chart-line"></i> Payment Analytics Dashboard
                </h1>
                <p class="mb-0 mt-2">Comprehensive payment tracking and analytics</p>
            </div>
            <div class="col-md-6 text-md-end">
                <button class="btn btn-export me-2" onclick="exportData()">
                    <i class="fas fa-download"></i> Export Data
                </button>
                <button class="btn btn-light" onclick="refreshDashboard()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Analytics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="dashboard-card info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">{{ number_format($total_payments) }}</h3>
                        <p class="mb-0">Total Payments</p>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="dashboard-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">{{ number_format($success_count) }}</h3>
                        <p class="mb-0">Successful Payments</p>
                        <small>{{ $total_payments > 0 ? round(($success_count / $total_payments) * 100, 1) : 0 }}% Success Rate</small>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="dashboard-card danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">{{ number_format($failed_count) }}</h3>
                        <p class="mb-0">Failed Payments</p>
                        <small>{{ $total_payments > 0 ? round(($failed_count / $total_payments) * 100, 1) : 0 }}% Failure Rate</small>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="dashboard-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">₹{{ number_format($total_amount, 2) }}</h3>
                        <p class="mb-0">Total Revenue</p>
                        <small>From successful payments</small>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mini Analytics Row -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-pie text-primary"></i> Payment Status
                    </h6>
                    <small class="text-muted">Distribution</small>
                </div>
                <div class="row">
                    @php
                        $total = $status_distribution->sum();
                    @endphp
                    @foreach($status_distribution as $status => $count)
                        @php
                            $percentage = $total > 0 ? round(($count / $total) * 100, 1) : 0;
                            $statusColor = $status == 'paid' ? 'success' : ($status == 'pending' ? 'warning' : 'danger');
                        @endphp
                        <div class="col-4 text-center">
                            <div class="mini-chart-item">
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $statusColor }}" style="width: {{ $percentage }}%"></div>
                                </div>
                                <h6 class="mb-0">{{ $count }}</h6>
                                <small class="text-{{ $statusColor }}">{{ ucfirst($status) }}</small>
                                <br><small class="text-muted">{{ $percentage }}%</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">
                        <i class="fas fa-credit-card text-info"></i> Payment Methods
                    </h6>
                    <small class="text-muted">Usage</small>
                </div>
                <div class="payment-methods-mini">
                    @php
                        $methodTotal = $payment_mode_distribution->sum();
                        $methodColors = ['upi' => 'primary', 'card' => 'success', 'netbanking' => 'info', 'wallet' => 'warning'];
                    @endphp
                    @foreach($payment_mode_distribution as $method => $count)
                        @php
                            $methodPercentage = $methodTotal > 0 ? round(($count / $methodTotal) * 100, 1) : 0;
                            $color = $methodColors[$method] ?? 'secondary';
                        @endphp
                        <div class="method-item d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <div class="method-icon bg-{{ $color }}" style="width: 12px; height: 12px; border-radius: 50%; margin-right: 8px;"></div>
                                <span class="small">{{ strtoupper($method) }}</span>
                            </div>
                            <div class="text-end">
                                <strong class="small">{{ $count }}</strong>
                                <small class="text-muted">({{ $methodPercentage }}%)</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="mini-stat-card">
                <div class="d-flex align-items-center">
                    <div class="mini-stat-icon bg-primary">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ round($success_rate, 1) }}%</h6>
                        <small class="text-muted">Success Rate</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="mini-stat-card">
                <div class="d-flex align-items-center">
                    <div class="mini-stat-icon bg-success">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">₹{{ number_format($avg_transaction_value, 0) }}</h6>
                        <small class="text-muted">Avg Transaction</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="mini-stat-card">
                <div class="d-flex align-items-center">
                    <div class="mini-stat-icon bg-info">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ $pending_count }}</h6>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="mini-stat-card">
                <div class="d-flex align-items-center">
                    <div class="mini-stat-icon bg-warning">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ \Carbon\Carbon::today()->format('M d') }}</h6>
                        <small class="text-muted">Today</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <h5 class="mb-3">
            <i class="fas fa-filter"></i> Advanced Filters
        </h5>
        <form method="GET" action="{{ route('admin.payments') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Payment Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Payment Method</label>
                <select name="payment_mode" class="form-select">
                    <option value="">All Methods</option>
                    <option value="upi" {{ request('payment_mode') == 'upi' ? 'selected' : '' }}>UPI</option>
                    <option value="card" {{ request('payment_mode') == 'card' ? 'selected' : '' }}>Card</option>
                    <option value="netbanking" {{ request('payment_mode') == 'netbanking' ? 'selected' : '' }}>Net Banking</option>
                    <option value="wallet" {{ request('payment_mode') == 'wallet' ? 'selected' : '' }}>Wallet</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-filter me-2">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('admin.payments') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i> Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="payments-table">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Transaction ID</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>
                                <strong>{{ $payment->order_id }}</strong>
                                @if($payment->cf_order_id)
                                    <br><small class="text-muted">CF: {{ $payment->cf_order_id }}</small>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $payment->customer_name }}</strong>
                                    <br><small class="text-muted">{{ $payment->customer_email }}</small>
                                    @if($payment->customer_phone)
                                        <br><small class="text-muted">{{ $payment->customer_phone }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <strong class="text-success">₹{{ number_format($payment->amount, 2) }}</strong>
                                <br><small class="text-muted">{{ $payment->currency }}</small>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $payment->status }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>
                                @if($payment->payment_mode)
                                    <span class="badge bg-primary">{{ strtoupper($payment->payment_mode) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($payment->transaction_id)
                                    <code>{{ $payment->transaction_id }}</code>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    {{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}
                                    <br><small class="text-muted">{{ \Carbon\Carbon::parse($payment->created_at)->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewPaymentDetails('{{ $payment->order_id }}')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($payment->status == 'paid')
                                        <button type="button" class="btn btn-sm btn-outline-success" onclick="downloadInvoice('{{ $payment->order_id }}')">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    @endif
                                    @if($payment->status == 'failed')
                                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="retryPayment('{{ $payment->order_id }}')">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-credit-card text-muted" style="font-size: 48px;"></i>
                                <p class="text-muted mt-3">No payments found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($payments->hasPages())
            <div class="p-3 border-top">
                {{ $payments->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Payment Details Modal -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="paymentDetailsContent">
                <!-- Payment details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
// Functions
function viewPaymentDetails(orderId) {
    // Load payment details via AJAX
    fetch(`/admin/payments/${orderId}/details`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('paymentDetailsContent').innerHTML = data.html;
            new bootstrap.Modal(document.getElementById('paymentDetailsModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading payment details');
        });
}

function downloadInvoice(orderId) {
    window.open(`/admin/payments/${orderId}/invoice`, '_blank');
}

function retryPayment(orderId) {
    if (confirm('Are you sure you want to retry this payment?')) {
        // Implement retry logic
        alert('Retry functionality would be implemented here');
    }
}

function exportData() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'excel');
    window.open(`${window.location.pathname}?${params.toString()}`, '_blank');
}

function refreshDashboard() {
    window.location.reload();
}

// Auto-refresh every 5 minutes
setInterval(function() {
    // Update only the analytics cards without full page reload
    fetch(window.location.href + '?ajax=1')
        .then(response => response.json())
        .then(data => {
            // Update analytics cards
            // This would be implemented to update specific elements
        });
}, 300000); // 5 minutes
</script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection