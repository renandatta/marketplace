<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Kurir</th>
        <th>Nama</th>
        <th width="100px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($courierServices as $key => $courierService)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $courierService->courier->name }}</td>
            <td>{{ $courierService->name }}</td>
            <td class="text-center">
                <a href="{{ route('management.courier.service.info', ['id=' . $courierService->id, 'courier_id=' . $courierId]) }}"><i class="fa fa-edit"></i> Ubah</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $courierServices->links('vendor.pagination.default') }}
