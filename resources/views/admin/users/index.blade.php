@extends('admin.layout')

@section('content')

<h2 style="font-size:22px; font-weight:600; margin-bottom:20px;">
    Manajemen Pengguna
</h2>

<div style="background:white; padding:20px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">

<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="background:#f5f5f5; text-align:left;">
            <th style="padding:12px;">Nama Pengguna</th>
            <th style="padding:12px;">Email</th>
            <th style="padding:12px;">Role</th>
            <th style="padding:12px;">Nama Toko</th>
            <th style="padding:12px;">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $u)
        <tr style="border-bottom:1px solid #e5e5e5;">
            <td style="padding:12px;">{{ $u->name }}</td>
            <td style="padding:12px;">{{ $u->email }}</td>

            <td style="padding:12px;">
                <span style="
                    padding:4px 10px;
                    font-size:12px;
                    border-radius:6px;
                    background: 
                        {{ $u->role=='admin' ? '#ffe08a' : ($u->role=='seller' ? '#bde0fe' : '#d3f9d8') }};
                ">
                    {{ $u->role }}
                </span>
            </td>

            <td style="padding:12px;">
                @if($u->store)
                    {{ $u->store->name }}
                @else
                    -
                @endif
            </td>

            <td style="padding:12px;">
                <a href="{{ route('admin.users.edit',$u->id) }}" style="color:#2563eb;">
                    Edit
                </a>

                <span style="margin:0 5px;">|</span>

                <form action="{{ route('admin.users.destroy',$u->id) }}" 
                      method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button style="color:#dc2626; background:none; border:none; cursor:pointer;">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection
