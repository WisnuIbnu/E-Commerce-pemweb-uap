<x-seller-layout title="Withdrawal History">

<div class="seller-card">

<table class="table">
    <tr>
        <th>Amount</th>
        <th>Status</th>
        <th>Date</th>
    </tr>

    @foreach ($withdrawals as $w)
    <tr>
        <td>Rp {{ number_format($w->amount,0,',','.') }}</td>
        <td>{{ $w->status }}</td>
        <td>{{ $w->created_at->format('d M Y') }}</td>
    </tr>
    @endforeach
</table>

</div>

</x-seller-layout>