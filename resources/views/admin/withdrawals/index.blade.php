@extends('layouts.admin')

@section('title', 'Persetujuan Penarikan Dana')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i>
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-times-circle"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="page-title">
        <i class="fas fa-money-check-alt"></i>
        Persetujuan Penarikan Dana
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card" style="border-left: 4px solid #f59e0b;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block mb-1">Menunggu Persetujuan</small>
                        <h3 class="mb-0" style="color: #f59e0b; font-weight: 700;">{{ $stats['pending'] }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; background: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock" style="font-size: 24px; color: #f59e0b;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="border-left: 4px solid #10b981;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block mb-1">Disetujui</small>
                        <h3 class="mb-0" style="color: #10b981; font-weight: 700;">{{ $stats['approved'] }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; background: #d1fae5; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle" style="font-size: 24px; color: #10b981;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="border-left: 4px solid #ef4444;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block mb-1">Ditolak</small>
                        <h3 class="mb-0" style="color: #ef4444; font-weight: 700;">{{ $stats['rejected'] }}</h3>
                    </div>
                    <div style="width: 50px; height: 50px; background: #fee2e2; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-times-circle" style="font-size: 24px; color: #ef4444;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="border-left: 4px solid #3b82f6;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block mb-1">Total Dicairkan</small>
                        <h5 class="mb-0" style="color: #3b82f6; font-weight: 700; font-size: 18px;">
                            Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}
                        </h5>
                    </div>
                    <div style="width: 50px; height: 50px; background: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-wallet" style="font-size: 24px; color: #3b82f6;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Withdrawals Table -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-table"></i> Daftar Penarikan Dana
    </div>
    <div class="card-body">
        @if($withdrawals->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Nama Toko</th>
                            <th>Pemilik</th>
                            <th>Jumlah</th>
                            <th>Bank</th>
                            <th>Rekening</th>
                            <th>Tanggal Pengajuan</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($withdrawals as $withdrawal)
                            <tr>
                                <td><strong>{{ $withdrawals->firstItem() + $loop->index }}</strong></td>
                                <td>
                                    <strong>{{ $withdrawal->storeBalance->store->name }}</strong>
                                </td>
                                <td>
                                    <div>{{ $withdrawal->storeBalance->store->user->name }}</div>
                                    <small class="text-muted">{{ $withdrawal->storeBalance->store->user->email }}</small>
                                </td>
                                <td>
                                    <span style="background: #dbeafe; color: #1e40af; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                                        Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $withdrawal->bank_name }}</strong>
                                </td>
                                <td>
                                    <div>{{ $withdrawal->bank_account_name }}</div>
                                    <small class="text-muted">{{ $withdrawal->bank_account_number }}</small>
                                </td>
                                <td>
                                    <div>{{ $withdrawal->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $withdrawal->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    @if($withdrawal->status === 'pending')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @elseif($withdrawal->status === 'approved')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Disetujui
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.withdrawals.show', $withdrawal->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div style="color: #64748b; font-size: 13px;">
                    Menampilkan <strong>{{ $withdrawals->firstItem() }}</strong> hingga <strong>{{ $withdrawals->lastItem() }}</strong> dari <strong>{{ $withdrawals->total() }}</strong> penarikan
                </div>
                <div>
                    {{ $withdrawals->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h5 style="color: #94a3b8; margin-top: 15px;">Belum Ada Penarikan Dana</h5>
                <p style="margin-top: 10px;">Tidak ada pengajuan penarikan dana saat ini</p>
            </div>
        @endif
    </div>
</div>

@endsection
