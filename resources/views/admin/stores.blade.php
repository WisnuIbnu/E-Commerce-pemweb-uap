@extends('layouts.app')

@section('content')
    <h2>Pengajuan Toko</h2>
    @foreach($stores as $store)
        <div>
            <h3>{{ $store->name }}</h3>
            <p>{{ $store->description }}</p>
            <form action="{{ route('admin.stores.approve', $store->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Setujui</button>
            </form>
            <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Tolak</button>
            </form>
        </div>
    @endforeach
@endsection
