@extends('admin.layout')

@section('title', 'Kelola User')

@section('content')
<h2 class="text-3xl font-bold mb-6">👥 Kelola User</h2>

{!! $table_html !!}
{{-- atau paste seluruh tabel user kamu di sini --}}
@endsection
