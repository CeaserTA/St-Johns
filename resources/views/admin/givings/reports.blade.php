@extends('layouts.dashboard_layout')

@section('title', 'Giving Reports')
@section('header_title', 'Giving Reports 📊')

@section('content')
<div class="space-y-6">
    <!-- Date Range Selector -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Report Period</h2>
        @if(!request('start_date') && !request('end_date'))
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <p class="text-blue-800 text-sm">
                    <strong>Showing all-time data.</strong> Use the date filters below to view specific periods.
                </p>
            </div>
        @endif
        <form method="GET" action="{{ route('admin.giving.reports') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" name="start_date" id="start_date" 
                       value="{{ request('start_date') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" name="end_date" id="end_date" 
                       value="{{ request('end_date') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">
                    Generate Report
                </button>
                <a href="{{ route('admin.giving.reports') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition duration-200">
                    Clear Filters
                </a>
            </div>
            <div class="flex items-end">
                <button type="button" onclick="exportReportCsv()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition duration-200">
                    📄 Export CSV
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="summary-cards">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Amount</p>
                    <p class="text-2xl font-bold text-gray-900" id="total-amount">Loading...</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tithes</p>
                    <p class="text-2xl font-bold text-gray-900" id="total-tithes">Loading...</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Offerings</p>
                    <p class="text-2xl font-bold text-gray-900" id="total-offerings">Loading...</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Donations</p>
                    <p class="text-2xl font-bold text-gray-900" id="total-donations">Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Payment Methods Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Methods</h3>
            <div id="payment-methods-chart" class="space-y-3">
                <!-- Chart will be populated by JavaScript -->
            </div>
        </div>

        <!-- Giving Types Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Giving Types</h3>
            <div id="giving-types-chart" class="space-y-3">
                <!-- Chart will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Detailed Breakdown -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detailed Breakdown</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metric</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                    </tr>
                </thead>
                <tbody id="breakdown-table" class="bg-white divide-y divide-gray-200">
                    <!-- Table will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Processing Fees Summary -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Processing Fees</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600">Total Fees</p>
                <p class="text-2xl font-bold text-red-600" id="total-fees">Loading...</p>
            </div>
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600">Net Amount</p>
                <p class="text-2xl font-bold text-green-600" id="net-amount">Loading...</p>
            </div>
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600">Fee Percentage</p>
                <p class="text-2xl font-bold text-gray-900" id="fee-percentage">Loading...</p>
            </div>
        </div>
    </div>

    <!-- Back to Givings -->
    <div class="text-center">
        <a href="{{ route('admin.givings') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition duration-200">
            ← Back to Givings
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadReportData();
});

function loadReportData() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    const params = new URLSearchParams({
        start_date: startDate,
        end_date: endDate
    });

    fetch(`{{ route('admin.giving.reports') }}?${params}`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateSummaryCards(data.summary);
            updateCharts(data.by_payment_method);
            updateBreakdownTable(data);
        }
    })
    .catch(error => {
        console.error('Error loading report data:', error);
    });
}

function updateSummaryCards(summary) {
    document.getElementById('total-amount').textContent = 
        new Intl.NumberFormat().format(summary.total_amount || 0) + ' UGX';
    document.getElementById('total-tithes').textContent = 
        new Intl.NumberFormat().format(summary.total_tithes || 0) + ' UGX';
    document.getElementById('total-offerings').textContent = 
        new Intl.NumberFormat().format(summary.total_offerings || 0) + ' UGX';
    document.getElementById('total-donations').textContent = 
        new Intl.NumberFormat().format(summary.total_donations || 0) + ' UGX';
    
    // Update processing fees
    document.getElementById('total-fees').textContent = 
        new Intl.NumberFormat().format(summary.processing_fees || 0) + ' UGX';
    
    const netAmount = (summary.total_amount || 0) - (summary.processing_fees || 0);
    document.getElementById('net-amount').textContent = 
        new Intl.NumberFormat().format(netAmount) + ' UGX';
    
    const feePercentage = summary.total_amount > 0 ? 
        ((summary.processing_fees || 0) / summary.total_amount * 100).toFixed(2) : '0.00';
    document.getElementById('fee-percentage').textContent = feePercentage + '%';
}

function updateCharts(paymentMethods) {
    const paymentChart = document.getElementById('payment-methods-chart');
    paymentChart.innerHTML = '';
    
    if (paymentMethods && paymentMethods.length > 0) {
        const totalAmount = paymentMethods.reduce((sum, method) => sum + parseFloat(method.total), 0);
        
        paymentMethods.forEach(method => {
            const percentage = totalAmount > 0 ? (method.total / totalAmount * 100).toFixed(1) : 0;
            
            const methodDiv = document.createElement('div');
            methodDiv.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';
            methodDiv.innerHTML = `
                <div>
                    <span class="font-medium">${method.payment_method.replace('_', ' ').toUpperCase()}</span>
                    <span class="text-sm text-gray-500">(${method.count} transactions)</span>
                </div>
                <div class="text-right">
                    <div class="font-bold">${new Intl.NumberFormat().format(method.total)} UGX</div>
                    <div class="text-sm text-gray-500">${percentage}%</div>
                </div>
            `;
            paymentChart.appendChild(methodDiv);
        });
    } else {
        paymentChart.innerHTML = '<p class="text-gray-500 text-center">No payment data available</p>';
    }
}

function updateBreakdownTable(data) {
    const tableBody = document.getElementById('breakdown-table');
    tableBody.innerHTML = '';
    
    const summary = data.summary;
    const totalAmount = summary.total_amount || 0;
    
    const breakdownData = [
        { metric: 'Completed Transactions', count: summary.transaction_count || 0, amount: totalAmount },
        { metric: 'Tithes', count: '-', amount: summary.total_tithes || 0 },
        { metric: 'Offerings', count: '-', amount: summary.total_offerings || 0 },
        { metric: 'Donations', count: '-', amount: summary.total_donations || 0 },
        { metric: 'Processing Fees', count: '-', amount: summary.processing_fees || 0 }
    ];
    
    breakdownData.forEach(item => {
        const percentage = totalAmount > 0 ? (item.amount / totalAmount * 100).toFixed(1) : '0.0';
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.metric}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.count}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Intl.NumberFormat().format(item.amount)} UGX</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${percentage}%</td>
        `;
        tableBody.appendChild(row);
    });
}

function exportReportCsv() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    const params = new URLSearchParams();
    if (startDate) params.append('start_date', startDate);
    if (endDate) params.append('end_date', endDate);
    
    const url = `/admin/givings/export-csv?${params.toString()}`;
    
    // Create a temporary link and click it to download
    const link = document.createElement('a');
    link.href = url;
    link.download = '';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Show success message
    showAlert('CSV export started. Your download should begin shortly.');
}

function showAlert(message) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = 'fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm bg-green-100 border border-green-400 text-green-700';
    alertDiv.innerHTML = `
        <div class="flex items-center">
            <span class="flex-1">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}

// Auto-refresh when date inputs change
document.getElementById('start_date').addEventListener('change', loadReportData);
document.getElementById('end_date').addEventListener('change', loadReportData);
</script>
@endsection