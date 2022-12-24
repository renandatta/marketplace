<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th>Kota</th>
        <th>Provinsi</th>
        <th>No.Telp</th>
        <th>Level</th>
        <th width="80px"></th>
        <th width="80px"></th>
        <th width="80px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($stores as $key => $store)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $store->name }}</td>
            <td>{{ $store->city }}</td>
            <td>{{ $store->province }}</td>
            <td>{{ $store->phone }}</td>
            <td>{{ $store->store_level->name }}</td>
            <td class="text-center">
                <a href="{{ route('management.store.info', 'id=' . $store->id) }}"><i class="fa fa-edit"></i> Ubah</a>
            </td>
            <td class="text-center">
                <a href="{{ route('management.store.product', 'store_id=' . $store->id) }}"><i class="fa fa-box"></i> Produk</a>
            </td>
            <td class="text-center">
                <a href="{{ route('management.store.user', 'store_id=' . $store->id) }}"><i class="fa fa-user"></i> User</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $stores->links('vendor.pagination.default') }}
