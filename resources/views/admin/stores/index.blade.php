@extends('admin.layouts.admin')

@section('content')

<style>
    /* BUTTON STYLE PASTEL */
    .btn-approve {
        background: #A8E6A3;
        color: #000;
        font-weight: 700;
        padding: 6px 16px;
        border-radius: 8px;
        border: none;
    }

    .btn-reject {
        background: #FFE9A3;
        color: #000;
        font-weight: 700;
        padding: 6px 16px;
        border-radius: 8px;
        border: none;
    }

    .btn-delete {
        background: #FFB5B5;
        color: #000;
        font-weight: 700;
        padding: 6px 16px;
        border-radius: 8px;
        border: none;
    }

    /* Agar tombol sejajar rapi */
    .action-buttons {
        display: flex;
        gap: 10px;
    }
</style>

<div class="container mt-4">

    <h3 class="mb-4 fw-bold">Manage Stores</h3>

    {{-- VERIFIED STORES --}}
    <div class="card mb-4 shadow">
        <div class="card-header bg-success text-white fw-bold">
            Verified Stores
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40%">Store Name</th>
                        <th width="30%">City</th>
                        <th width="30%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($verifiedStores as $store)
                    <tr>
                        <td>{{ $store->name }}</td>
                        <td>{{ $store->city }}</td>

                        <td>
                            <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus store ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete w-100">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-3">
                            Tidak ada store terverifikasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    {{-- PENDING STORES --}}
    <div class="card mb-4 shadow">
        <div class="card-header bg-warning fw-bold">
            Pending Stores
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="35%">Store Name</th>
                        <th width="25%">City</th>
                        <th width="40%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pendingStores as $store)
                    <tr>
                        <td>{{ $store->name }}</td>
                        <td>{{ $store->city }}</td>

                        <td>
                            <div class="action-buttons">

                                {{-- Approve --}}
                                <form action="{{ route('admin.stores.approve', $store->id) }}" method="POST">
                                    @csrf
                                    <button class="btn-approve">Approve</button>
                                </form>

                                {{-- Reject --}}
                                <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST">
                                    @csrf
                                    <button class="btn-reject">Reject</button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus store ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-delete">Delete</button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-3">
                            Tidak ada store pending.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
