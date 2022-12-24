<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th width="100px"></th>
        <th width="200px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($couriers as $key => $courier)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $courier->name }}</td>
            <td class="text-center">
                <a href="{{ route('management.courier.info', 'id=' . $courier->id) }}"><i class="fa fa-edit"></i> Ubah</a>
            </td>
            <td class="text-center">
                <a href="{{ route('management.courier.service', 'courier_id=' . $courier->id) }}"><i class="fa fa-list"></i> Layanan Pengiriman</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $couriers->links('vendor.pagination.default') }}
