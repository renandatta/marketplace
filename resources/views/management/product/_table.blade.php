<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        @if($store_id == null)
            <th>Toko</th>
        @endif
        <th class="text-right">Harga</th>
        <th class="text-right">Stok</th>
        <th class="text-right">Stok Min</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $key => $product)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $product->name }}</td>
            @if($store_id == null)
                <td>{{ $product->store->name }}</td>
            @endif
            <td class="text-right">{{ format_number($product->price) }}</td>
            <td class="text-right">{{ $product->stock }}</td>
            <td class="text-right">{{ $product->stock_min }}</td>
            <td class="text-center">
                @php($parameters = [])
                @php(array_push($parameters, 'id=' . $product->id))
                @if($store_id != null)
                    @php(array_push($parameters, 'store_id=' . $store_id))
                @endif
                <a href="{{ route('management.store.product.info', $parameters) }}"><i class="fa fa-edit"></i> Ubah</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $products->links('vendor.pagination.default') }}
