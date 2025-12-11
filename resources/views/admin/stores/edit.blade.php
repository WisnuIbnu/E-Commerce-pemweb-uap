@extends('admin.layout')

@section('content')
<h1>Edit Store Status</h1>

<div class="card">

<form action="{{ route('admin.stores.update',$store->id) }}" method="POST">
    @csrf @method('PUT')

    <label>Status</label>
    <select name="status" style="padding:10px;width:100%;margin:10px 0;">
        <option value="pending"  @selected($store->status=='pending')>Pending</option>
        <option value="approved" @selected($store->status=='approved')>Approved</option>
        <option value="rejected" @selected($store->status=='rejected')>Rejected</option>
    </select>

    <button style="padding:10px 20px;background:#FF7A00;color:white;border:none;border-radius:6px;">
        Save
    </button>
</form>

</div>
@endsection
