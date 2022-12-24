<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>No.Transaksi</th>
        <th>Pembeli</th>
        <th>Toko</th>
        <th>Produk</th>
        <th class="text-right">Qty</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $key => $transaction)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $transaction->purchase->no_purchase }}</td>
            <td>{{ $transaction->purchase->user->name }}</td>
            <td>{{ $transaction->product->store->name }}</td>
            <td>{{ $transaction->product->name }}</td>
            <td class="text-right">{{ $transaction->qty }}</td>
            <td>{{ $transaction->purchase->status_list[0]->status }}</td>
            <td>
                <a href="{{ route('management.transaction.detail', 'no_order=' . $transaction->purchase->no_purchase) }}">Detail</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $transactions->links('vendor.pagination.default') }}
