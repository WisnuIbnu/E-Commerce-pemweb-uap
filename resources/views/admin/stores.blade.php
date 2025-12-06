@extends('layouts.admin')

@section('title', 'Kelola Toko - Admin FlexSport')

@push('styles')
<style>
    .content { 
        padding: 3rem 2rem; 
    }
    
    .container { 
        max-width: 1200px; 
        margin: 0 auto; 
    }
    
    .page-header { 
        background: white; 
        padding: 2rem; 
        border-radius: 20px; 
        margin-bottom: 2rem; 
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
    }
    
    .page-header h1 {
        color: #003459;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }
    
    .alert { 
        padding: 1rem; 
        border-radius: 10px; 
        margin-bottom: 1.5rem; 
    }
    
    .alert-success { 
        background: #d4edda; 
        color: #155724; 
    }
    
    .alert-error { 
        background: #f8d7da; 
        color: #721c24; 
    }
    
    .card { 
        background: white; 
        border-radius: 20px; 
        padding: 2rem; 
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
    }
    
    table { 
        width: 100%; 
        border-collapse: collapse; 
    }
    
    th, td { 
        padding: 1rem; 
        text-align: left; 
        border-bottom: 1px solid #E1E5EA; 
    }
    
    th { 
        background: #667eea; 
        color: white; 
        font-weight: 700;
    }
    
    tr:hover { 
        background: #f5f7fa; 
    }
    
    .badge { 
        padding: 0.5rem 1rem; 
        border-radius: 20px; 
        font-weight: 600; 
        font-size: 0.85rem; 
        display: inline-block;
    }
    
    .badge-verified { 
        background: #00C49A; 
        color: white; 
    }
    
    .badge-pending { 
        background: #ffc107; 
        color: #000; 
    }
    
    .btn { 
        padding: 0.5rem 1rem; 
        border: none; 
        border-radius: 8px; 
        font-weight: 600; 
        cursor: pointer; 
        margin: 0 0.25rem; 
        font-family: 'Sora', sans-serif;
        transition: all 0.3s;
    }
    
    .btn-approve { 
        background: #00C49A; 
        color: white; 
    }
    
    .btn-approve:hover {
        background: #00a882;
        transform: translateY(-2px);
    }
    
    .btn-reject { 
        background: #dc3545; 
        color: white; 
    }
    
    .btn-reject:hover {
        background: #c82333;
        transform: translateY(-2px);
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #666;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
</style>
@endpush

@section('content')
<div class="content">
    <div class="container">
        <div class="page-header">
            <h1>🏪 Kelola & Verifikasi Toko</h1>
            <p style="color: #666; margin-top: 0.5rem;">Verifikasi dan kelola toko yang terdaftar di FlexSport</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif

        <div class="card">
            @if(count($stores) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Nama Toko</th>
                        <th>Pemilik</th>
                        <th>Email</th>
                        <th>Kota</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stores as $store)
                    <tr>
                        <td><strong>{{ $store['name'] }}</strong></td>
                        <td>{{ $store['owner_name'] }}</td>
                        <td>{{ $store['email'] }}</td>
                        <td>{{ $store['city'] }}</td>
                        <td>
                            @if($store['is_verified'])
                                <span class="badge badge-verified">✅ Verified</span>
                            @else
                                <span class="badge badge-pending">⏳ Pending</span>
                            @endif
                        </td>
                        <td>
                            @if(!$store['is_verified'])
                            <div class="action-buttons">
                                <form method="POST" action="#" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="store_id" value="{{ $store['id'] }}">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" name="verify_store" class="btn btn-approve" 
                                            onclick="return confirm('Setujui verifikasi toko ini?')">
                                        ✅ Setujui
                                    </button>
                                </form>
                                <form method="POST" action="#" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="store_id" value="{{ $store['id'] }}">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" name="verify_store" class="btn btn-reject"
                                            onclick="return confirm('Tolak verifikasi toko ini?')">
                                        ❌ Tolak
                                    </button>
                                </form>
                            </div>
                            @else
                            <span style="color:#666;">✓ Sudah diverifikasi</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <h3>📭 Belum ada toko yang terdaftar</h3>
                <p>Toko yang mendaftar akan muncul di sini</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Additional JavaScript if needed
    console.log('Admin Stores Management Page Loaded');
</script>
@endpush