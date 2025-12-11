@extends('layouts.admin')

@section('title', 'Detail Penarikan Dana')

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

<div class="page-title mb-4">
    <i class="fas fa-money-check-alt"></i>
    Detail Penarikan Dana #{{ $withdrawal->id }}
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-information-circle"></i> Informasi Penarikan
            </div>
            <div class="card-body">
                <!-- Status Badge -->
                <div class="mb-4">
                    <label style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">
                        <i class="fas fa-info-circle"></i> Status
                    </label>
                    @if($withdrawal->status === 'pending')
                        <span class="badge bg-warning" style="padding: 10px 15px; font-size: 14px;">
                            <i class="fas fa-clock"></i> Menunggu Persetujuan
                        </span>
                    @elseif($withdrawal->status === 'approved')
                        <span class="badge bg-success" style="padding: 10px 15px; font-size: 14px;">
                            <i class="fas fa-check-circle"></i> Disetujui
                        </span>
                    @else
                        <span class="badge bg-danger" style="padding: 10px 15px; font-size: 14px;">
                            <i class="fas fa-times-circle"></i> Ditolak
                        </span>
                    @endif
                </div>

                <hr class="my-4">

                <!-- Informasi Toko -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">
                            <i class="fas fa-store"></i> Nama Toko
                        </label>
                        <h5 style="color: #1e3a8a; font-weight: 700; margin: 0;">{{ $withdrawal->storeBalance->store->name }}</h5>
                    </div>
                    <div class="col-md-6">
                        <label style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">
                            <i class="fas fa-user"></i> Pemilik Toko
                        </label>
                        <p style="color: #475569; margin: 0;">{{ $withdrawal->storeBalance->store->user->name }}</p>
                        <small class="text-muted">{{ $withdrawal->storeBalance->store->user->email }}</small>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Informasi Penarikan -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">
                            <i class="fas fa-money-bill-wave"></i> Jumlah Penarikan
                        </label>
                        <h3 style="color: #3b82f6; font-weight: 700; margin: 0;">
                            Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <label style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">
                            <i class="fas fa-wallet"></i> Saldo Toko Saat Ini
                        </label>
                        <h5 style="color: #10b981; font-weight: 700; margin: 0;">
                            Rp {{ number_format($withdrawal->storeBalance->balance, 0, ',', '.') }}
                        </h5>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Informasi Bank -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">
                            <i class="fas fa-university"></i> Informasi Rekening Bank
                        </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <small class="text-muted d-block mb-1">Nama Bank</small>
                        <strong style="color: #1e3a8a;">{{ $withdrawal->bank_name }}</strong>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block mb-1">Nama Pemilik Rekening</small>
                        <strong style="color: #1e3a8a;">{{ $withdrawal->bank_account_name }}</strong>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block mb-1">Nomor Rekening</small>
                        <strong style="color: #1e3a8a; font-family: monospace;">{{ $withdrawal->bank_account_number }}</strong>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Informasi Waktu -->
                <div class="row">
                    <div class="col-md-6">
                        <label style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">
                            <i class="fas fa-calendar"></i> Tanggal Pengajuan
                        </label>
                        <p style="color: #475569; margin: 0;">{{ $withdrawal->created_at->format('d M Y - H:i') }}</p>
                    </div>
                    @if($withdrawal->status === 'approved')
                        <div class="col-md-6">
                            <label style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">
                                <i class="fas fa-check-circle"></i> Tanggal Disetujui
                            </label>
                            <p style="color: #475569; margin: 0;">{{ $withdrawal->approved_at->format('d M Y - H:i') }}</p>
                        </div>
                    @elseif($withdrawal->status === 'rejected')
                        <div class="col-md-6">
                            <label style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">
                                <i class="fas fa-times-circle"></i> Tanggal Ditolak
                            </label>
                            <p style="color: #475569; margin: 0;">{{ $withdrawal->rejected_at->format('d M Y - H:i') }}</p>
                        </div>
                    @endif
                </div>

                @if($withdrawal->status === 'rejected' && $withdrawal->rejection_reason)
                    <hr class="my-4">
                    <div>
                        <label style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">
                            <i class="fas fa-comment"></i> Alasan Penolakan
                        </label>
                        <div style="background: #fee2e2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 8px;">
                            <p style="color: #991b1b; margin: 0;">{{ $withdrawal->rejection_reason }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Aksi -->
        @if($withdrawal->status === 'pending')
            <div class="card mt-4">
                <div class="card-header">
                    <i class="fas fa-cog"></i> Aksi Persetujuan
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.withdrawals.approve', $withdrawal->id) }}"
                           class="btn btn-success"
                           onclick="return confirm('Apakah Anda yakin ingin menyetujui penarikan ini? Saldo akan dikurangi sebesar Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}')">
                            <i class="fas fa-check"></i> Setujui Penarikan
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times"></i> Tolak Penarikan
                        </button>
                        <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="card mt-4">
                <div class="card-body text-center">
                    <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informasi Tambahan
            </div>
            <div class="card-body">
                @if($withdrawal->status === 'pending')
                    <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                        <p style="color: #92400e; font-size: 13px; margin: 0;">
                            <i class="fas fa-exclamation-triangle"></i> Penarikan ini <strong>menunggu persetujuan</strong> Anda.
                        </p>
                    </div>
                @elseif($withdrawal->status === 'approved')
                    <div style="background: #d1fae5; border-left: 4px solid #10b981; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                        <p style="color: #065f46; font-size: 13px; margin: 0;">
                            <i class="fas fa-check-circle"></i> Penarikan ini telah <strong>disetujui</strong> dan saldo telah dikurangi.
                        </p>
                    </div>
                @else
                    <div style="background: #fee2e2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                        <p style="color: #991b1b; font-size: 13px; margin: 0;">
                            <i class="fas fa-times-circle"></i> Penarikan ini telah <strong>ditolak</strong>.
                        </p>
                    </div>
                @endif

                @if($withdrawal->status === 'pending')
                    <div style="background: #dbeafe; border-left: 4px solid #3b82f6; padding: 15px; border-radius: 8px;">
                        <p style="color: #1e3a8a; font-size: 13px; margin: 0 0 10px 0; font-weight: 600;">
                            <i class="fas fa-calculator"></i> Simulasi Saldo:
                        </p>
                        <div style="font-size: 13px; color: #1e40af;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span>Saldo Saat Ini:</span>
                                <strong>Rp {{ number_format($withdrawal->storeBalance->balance, 0, ',', '.') }}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span>Jumlah Penarikan:</span>
                                <strong style="color: #dc2626;">- Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</strong>
                            </div>
                            <hr style="margin: 10px 0; border-top: 2px solid #3b82f6;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Saldo Setelah:</strong></span>
                                <strong>Rp {{ number_format($withdrawal->storeBalance->balance - $withdrawal->amount, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($withdrawal->status === 'pending')
            <div class="card mt-4">
                <div class="card-header">
                    <i class="fas fa-shield-alt"></i> Catatan Penting
                </div>
                <div class="card-body">
                    <div style="font-size: 13px; color: #475569;">
                        <p style="margin: 0 0 12px 0;">
                            <i class="fas fa-check-circle" style="color: #10b981;"></i>
                            <strong>Sebelum Menyetujui:</strong>
                        </p>
                        <ul style="margin: 0; padding-left: 20px; line-height: 1.8;">
                            <li>Verifikasi data rekening bank</li>
                            <li>Pastikan saldo toko mencukupi</li>
                            <li>Periksa riwayat penarikan sebelumnya</li>
                            <li>Saldo akan otomatis dikurangi setelah disetujui</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle me-2"></i>
                    Tolak Penarikan Dana
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Penarikan yang ditolak tidak dapat diproses kembali.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control"
                                  name="rejection_reason"
                                  rows="4"
                                  placeholder="Berikan alasan penolakan yang jelas..."
                                  required></textarea>
                        <small class="text-muted">Alasan ini akan dilihat oleh pemilik toko</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Tolak Penarikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
