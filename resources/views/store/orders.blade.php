<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">
        @include('profile.partials.navbar')

        <div class="flex-1">
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="breadcrumb-wrapper mb-4">
                        <div class="breadcrumb-container">
                            <a href="{{ route('dashboard') }}" class="breadcrumb-link">Home</a>
                            <span class="breadcrumb-separator">›</span>
                            <a href="{{ route('store.dashboard') }}" class="breadcrumb-link">Dashboard</a>
                            <span class="breadcrumb-separator">›</span>
                            <span class="breadcrumb-current">Orders</span>
                        </div>
                    </div>
                    
                    <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0;">📦 Order Management</h1>
                    <p style="margin: 8px 0 0 0; font-size: 14px; color: #6b7280;">Manage all your store orders</p>
                </div>
            </div>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    
                    @if(session('success'))
                    <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                        ✓ {{ session('success') }}
                    </div>
                    @endif

                    <!-- Filter Tabs -->
                    <div class="p-4 bg-white shadow sm:rounded-lg">
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <a href="{{ route('store.orders') }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $status == 'all' ? 'bg-burnt-sienna text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                               style="{{ $status == 'all' ? 'background-color: #984216;' : '' }}">
                                All Orders
                            </a>
                            <a href="{{ route('store.orders', ['status' => 'pending']) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $status == 'pending' ? 'bg-burnt-sienna text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                               style="{{ $status == 'pending' ? 'background-color: #984216;' : '' }}">
                                Pending
                            </a>
                            <a href="{{ route('store.orders', ['status' => 'process']) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $status == 'process' ? 'bg-burnt-sienna text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                               style="{{ $status == 'process' ? 'background-color: #984216;' : '' }}">
                                Process
                            </a>
                            <a href="{{ route('store.orders', ['status' => 'paid']) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $status == 'paid' ? 'bg-burnt-sienna text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                               style="{{ $status == 'paid' ? 'background-color: #984216;' : '' }}">
                                Paid
                            </a>
                        </div>
                    </div>

                    <!-- Orders List -->
                    <div class="p-6 bg-white shadow sm:rounded-lg">
                        @if($orders->count() > 0)
                            @foreach($orders as $order)
                            <div class="border border-gray-200 rounded-lg p-5 mb-4">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                                    <div>
                                        <div style="font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 5px;">Order #{{ $order->id }}</div>
                                        <div style="font-size: 13px; color: #6b7280;">Customer: {{ $order->buyer_name }}</div>
                                        <div style="font-size: 13px; color: #6b7280;">Email: {{ $order->buyer_email }}</div>
                                        <div style="font-size: 13px; color: #6b7280;">Date: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</div>
                                    </div>
                                    <div style="text-align: right;">
                                        <div style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 5px;">
                                            Rp {{ number_format($order->grand_total ?? 0, 0, ',', '.') }}
                                        </div>
                                        @if($order->payment_status == 'paid')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">✓ Paid</span>
                                        @elseif($order->payment_status == 'process')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">⏳ Process</span>
                                        @else
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">📋 Pending</span>
                                        @endif
                                    </div>
                                </div>

                                @if($order->tracking_number)
                                <div class="bg-gray-50 px-4 py-2 rounded-lg mb-3 text-sm text-gray-700">
                                    📦 Tracking Number: <strong>{{ $order->tracking_number }}</strong>
                                </div>
                                @endif

                                <div style="display: flex; gap: 10px;">
                                    <button onclick="openModal({{ $order->id }}, '{{ $order->payment_status }}', '{{ $order->tracking_number ?? '' }}')" 
                                            class="px-4 py-2 text-white rounded-lg text-sm font-medium"
                                            style="background-color: #984216;">
                                        Update Status
                                    </button>
                                </div>
                            </div>
                            @endforeach

                            <!-- Pagination -->
                            <div class="mt-6">
                                {{ $orders->links() }}
                            </div>
                        @else
                        <div class="text-center py-12">
                            <div style="font-size: 60px; margin-bottom: 20px;">📦</div>
                            <div style="font-size: 18px; color: #6b7280;">No orders found</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div id="updateModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Update Order Status</h2>
            
            <form id="updateForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="statusSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="pending">Pending</option>
                        <option value="process">Process</option>
                        <option value="paid">Paid</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tracking Number (Optional)</label>
                    <input type="text" name="tracking_number" id="trackingInput" placeholder="Enter tracking number" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>

                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-white rounded-lg" style="background-color: #984216;">Update Order</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .breadcrumb-wrapper { margin-bottom: 1rem; }
        .breadcrumb-container { display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; }
        .breadcrumb-link { color:#984216; text-decoration:none; transition:color .2s; }
        .breadcrumb-link:hover { color:#7a3412; text-decoration:underline; }
        .breadcrumb-separator { color:#9ca3af; font-size:1rem; }
        .breadcrumb-current { color:#6b7280; font-weight:500; }
    </style>

    <script>
        function openModal(orderId, currentStatus, trackingNumber) {
            document.getElementById('updateModal').style.display = 'flex';
            document.getElementById('updateForm').action = '/store/orders/' + orderId + '/update';
            document.getElementById('statusSelect').value = currentStatus;
            document.getElementById('trackingInput').value = trackingNumber;
        }

        function closeModal() {
            document.getElementById('updateModal').style.display = 'none';
        }

        document.getElementById('updateModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-app-layout>