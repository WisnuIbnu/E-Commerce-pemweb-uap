<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">
        @include('profile.partials.navbar')

        <div class="flex-1">
            <!-- Header with Breadcrumb -->
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
                    <div class="breadcrumb-wrapper mb-3 sm:mb-4">
                        <div class="breadcrumb-container">
                            <a href="{{ route('dashboard') }}" class="breadcrumb-link">Home</a>
                            <span class="breadcrumb-separator">›</span>
                            <span class="breadcrumb-current">Seller Dashboard</span>
                        </div>
                    </div>
                    
                    <h1 class="greeting-title">
                        Good {{ date('H') < 12 ? 'Morning' : (date('H') < 18 ? 'Afternoon' : 'Evening') }}, 
                        <span style="color: #984216;">{{ $store->name }}</span>
                    </h1>
                    <p class="greeting-subtitle">Welcome back to your store</p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="py-6 sm:py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">
                    
                    <!-- Summary Cards & Chart Row -->
                    <div class="chart-todo-grid">
                        
                        <!-- Sales Chart -->
                        <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                            <h3 class="section-title">Sales Chart</h3>
                            <div class="chart-container">
                                <canvas id="salesChart" width="600" height="300"></canvas>
                            </div>
                        </div>

                        <!-- To Do List Summary -->
                        <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                            <h3 class="section-title">To Do List</h3>
                            <div class="todo-grid">
                                <div class="todo-item">
                                    <div class="todo-number">{{ $totalOrders - $completedOrders }}</div>
                                    <div class="todo-label">Unpaid Orders</div>
                                </div>
                                <div class="todo-item">
                                    <div class="todo-number">{{ $onProcess }}</div>
                                    <div class="todo-label">In Process</div>
                                </div>
                                <div class="todo-item">
                                    <div class="todo-number">{{ $completedOrders }}</div>
                                    <div class="todo-label">Completed</div>
                                </div>
                                <div class="todo-item">
                                    <div class="todo-number">{{ $totalOrders }}</div>
                                    <div class="todo-label">Total Orders</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards Row -->
                    <div class="stats-grid">
                        
                        <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                            <div class="stat-label">📊 Total Orders</div>
                            <div class="stat-value">{{ $totalOrders }}</div>
                            <div class="stat-change">+12% from last month</div>
                        </div>

                        <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                            <div class="stat-label">💰 Revenue</div>
                            <div class="stat-value">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</div>
                            <div class="stat-change">This month</div>
                        </div>

                        <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                            <div class="stat-label">👥 Customers</div>
                            <div class="stat-value">{{ $customerCount }}</div>
                            <div class="stat-change">Total buyers</div>
                        </div>

                        <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                            <div class="stat-label">💳 Balance</div>
                            <div class="stat-value">Rp {{ number_format($balance->balance ?? 0, 0, ',', '.') }}</div>
                            <a href="{{ route('store.withdrawal') }}" class="stat-link">Withdraw →</a>
                        </div>
                    </div>

                    <!-- Top Products & Recent Orders Row -->
                    <div class="products-transactions-grid">
                        
                        <!-- Top Selling Products -->
                        <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                            <h3 class="section-title">Top Selling Products</h3>

                            <div class="products-grid">
                                @foreach($topProducts as $product)
                                <div class="product-item">
                                    <div class="product-image">
                                        @php
                                            // Cari gambar pertama dengan format id-1.jpeg, id-1.jpg, id-1.png, dll
                                            $imagePath = null;
                                            $extensions = ['jpeg', 'jpg', 'png', 'webp'];
                                            foreach ($extensions as $ext) {
                                                $path = "images/products/{$product->id}-1.{$ext}";
                                                if (file_exists(public_path($path))) {
                                                    $imagePath = $path;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        
                                        @if($imagePath)
                                            <img src="{{ asset($imagePath) }}" 
                                                 alt="{{ $product->name }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover;"
                                                 onerror="this.parentElement.innerHTML='<div style=\'width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 40px;\'>🌿</div>'">
                                        @else
                                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 40px;">
                                                🌿
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product-name">
                                        {{ Str::limit($product->name, 12) }}
                                    </div>
                                    <div class="product-badge">
                                        {{ $product->total_sold }} sold
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Recent Transactions -->
                        <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                            <h3 class="section-title">Latest Transactions</h3>
                            <div class="table-responsive">
                                <table class="transactions-table">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentTransactions as $transaction)
                                        <tr>
                                            <td data-label="Invoice">#{{ $transaction->id }}</td>
                                            <td data-label="Customer">{{ Str::limit($transaction->buyer_name, 15) }}</td>
                                            <td data-label="Amount">Rp {{ number_format($transaction->grand_total ?? 0, 0, ',', '.') }}</td>
                                            <td data-label="Status">
                                                @if($transaction->payment_status == 'paid')
                                                <span class="status-badge status-paid">Paid</span>
                                                @elseif($transaction->payment_status == 'process')
                                                <span class="status-badge status-process">Process</span>
                                                @else
                                                <span class="status-badge status-pending">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info Card -->
                    <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg text-center">
                        <h3 class="section-title" style="text-align: center;">Total Customers</h3>
                        <div class="customer-count">{{ $customerCount }}</div>
                        <div class="customer-label">Active Users</div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        /* Breadcrumb */
        .breadcrumb-wrapper { margin-bottom: 1rem; }
        .breadcrumb-container { 
            display: flex; 
            align-items: center; 
            gap: 0.5rem; 
            font-size: 0.875rem;
            flex-wrap: wrap;
        }
        .breadcrumb-link { 
            color: #984216; 
            text-decoration: none; 
            transition: color .2s; 
        }
        .breadcrumb-link:hover { 
            color: #7a3412; 
            text-decoration: underline; 
        }
        .breadcrumb-separator { color: #9ca3af; font-size: 1rem; }
        .breadcrumb-current { color: #6b7280; font-weight: 500; }

        /* Greeting */
        .greeting-title {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }
        .greeting-subtitle {
            margin: 8px 0 0 0;
            font-size: 14px;
            color: #6b7280;
        }

        /* Section Title */
        .section-title {
            margin: 0 0 16px 0;
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
        }

        /* Chart and Todo Grid */
        .chart-todo-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        /* Chart Container */
        .chart-container {
            overflow-x: auto;
            overflow-y: hidden;
        }
        #salesChart {
            min-width: 400px;
        }

        /* Todo Grid */
        .todo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .todo-item {
            text-align: center;
        }
        .todo-number {
            font-size: 24px;
            font-weight: bold;
            color: #984216;
            margin-bottom: 5px;
        }
        .todo-label {
            font-size: 11px;
            color: #6b7280;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .stat-label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
        }
        .stat-value {
            font-size: 22px;
            font-weight: bold;
            color: #1f2937;
            word-break: break-word;
        }
        .stat-change {
            font-size: 12px;
            color: #10b981;
            margin-top: 5px;
        }
        .stat-link {
            font-size: 12px;
            color: #984216;
            margin-top: 5px;
            display: inline-block;
            text-decoration: none;
        }
        .stat-link:hover {
            text-decoration: underline;
        }

        /* Products and Transactions Grid */
        .products-transactions-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .product-item {
            text-align: center;
        }
        .product-image {
            width: 100%;
            aspect-ratio: 1;
            background: #f9fafb;
            border-radius: 8px;
            margin-bottom: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        .product-name {
            font-size: 12px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 5px;
        }
        .product-badge {
            background: #fef3e2;
            color: #984216;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 4px;
            display: inline-block;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }
        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px;
        }
        .transactions-table thead tr {
            border-bottom: 2px solid #f3f4f6;
        }
        .transactions-table th {
            text-align: left;
            padding: 10px 8px;
            font-size: 11px;
            color: #6b7280;
            font-weight: 600;
        }
        .transactions-table tbody tr {
            border-bottom: 1px solid #f3f4f6;
        }
        .transactions-table td {
            padding: 12px 8px;
            font-size: 12px;
            color: #1f2937;
        }
        .status-badge {
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
            display: inline-block;
            white-space: nowrap;
        }
        .status-paid {
            background: #d1fae5;
            color: #065f46;
        }
        .status-process {
            background: #fef3c7;
            color: #92400e;
        }
        .status-pending {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Customer Card */
        .customer-count {
            font-size: 36px;
            font-weight: bold;
            color: #984216;
            margin: 16px 0;
        }
        .customer-label {
            font-size: 14px;
            color: #6b7280;
        }

        /* Tablet (min-width: 640px) */
        @media (min-width: 640px) {
            .greeting-title {
                font-size: 24px;
            }
            .section-title {
                font-size: 16px;
                margin-bottom: 20px;
            }
            .todo-number {
                font-size: 28px;
            }
            .todo-label {
                font-size: 12px;
            }
            .stat-value {
                font-size: 24px;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
            }
            .product-name {
                font-size: 13px;
            }
            .product-badge {
                font-size: 11px;
            }
            .transactions-table th {
                font-size: 12px;
                padding: 10px;
            }
            .transactions-table td {
                font-size: 13px;
                padding: 12px 10px;
            }
            .status-badge {
                font-size: 11px;
            }
            .customer-count {
                font-size: 42px;
                margin: 20px 0;
            }
        }

        /* Desktop (min-width: 1024px) */
        @media (min-width: 1024px) {
            .greeting-title {
                font-size: 28px;
            }
            .chart-todo-grid {
                grid-template-columns: 2fr 1fr;
                gap: 24px;
            }
            .todo-number {
                font-size: 32px;
            }
            .stat-value {
                font-size: 28px;
            }
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
            .products-transactions-grid {
                grid-template-columns: 1fr 1fr;
                gap: 24px;
            }
            .products-grid {
                grid-template-columns: repeat(5, 1fr);
            }
            .customer-count {
                font-size: 48px;
            }
        }

        /* Mobile Table View */
        @media (max-width: 639px) {
            .transactions-table {
                min-width: auto;
            }
            .transactions-table thead {
                display: none;
            }
            .transactions-table tbody tr {
                display: block;
                margin-bottom: 12px;
                border: 1px solid #f3f4f6;
                border-radius: 8px;
                padding: 12px;
            }
            .transactions-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border-bottom: 1px solid #f9fafb;
            }
            .transactions-table td:last-child {
                border-bottom: none;
            }
            .transactions-table td:before {
                content: attr(data-label);
                font-weight: 600;
                color: #6b7280;
                font-size: 11px;
            }
        }
    </style>

    <script>
        // Simple Canvas Chart - Responsive
        function drawChart() {
            const canvas = document.getElementById('salesChart');
            const ctx = canvas.getContext('2d');
            
            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            const salesData = @json($salesData);
            const values = salesData.map(d => d.amount);
            const labels = salesData.map(d => d.date);
            
            const maxValue = Math.max(...values) || 1000000;
            const padding = 40;
            const chartWidth = canvas.width - padding * 2;
            const chartHeight = canvas.height - padding * 2;
            
            // Draw grid
            ctx.strokeStyle = '#f3f4f6';
            ctx.lineWidth = 1;
            for (let i = 0; i <= 5; i++) {
                const y = padding + (chartHeight / 5) * i;
                ctx.beginPath();
                ctx.moveTo(padding, y);
                ctx.lineTo(canvas.width - padding, y);
                ctx.stroke();
            }
            
            // Draw line
            ctx.strokeStyle = '#984216';
            ctx.lineWidth = 3;
            ctx.beginPath();
            values.forEach((value, index) => {
                const x = padding + (chartWidth / (values.length - 1)) * index;
                const y = padding + chartHeight - (value / maxValue) * chartHeight;
                if (index === 0) {
                    ctx.moveTo(x, y);
                } else {
                    ctx.lineTo(x, y);
                }
            });
            ctx.stroke();
            
            // Draw points
            ctx.fillStyle = '#984216';
            values.forEach((value, index) => {
                const x = padding + (chartWidth / (values.length - 1)) * index;
                const y = padding + chartHeight - (value / maxValue) * chartHeight;
                ctx.beginPath();
                ctx.arc(x, y, 5, 0, Math.PI * 2);
                ctx.fill();
            });
            
            // Draw labels
            ctx.fillStyle = '#6b7280';
            ctx.font = '11px Arial';
            ctx.textAlign = 'center';
            labels.forEach((label, index) => {
                if (index % 2 === 0) {
                    const x = padding + (chartWidth / (values.length - 1)) * index;
                    ctx.fillText(label, x, canvas.height - 15);
                }
            });
        }
        
        // Draw chart on load
        drawChart();
        
        // Redraw chart on window resize
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(drawChart, 250);
        });
    </script>
</x-app-layout>