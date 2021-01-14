<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th>Keterangan</th>
        <th width="100px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($productCategorys as $key => $productCategory)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $productCategory->name }}</td>
            <td>{{ $productCategory->description }}</td>
            <td class="text-center">
                <a href="{{ route('management.product_category.info', 'id=' . $productCategory->id) }}"><i class="fa fa-edit"></i> Ubah</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $productCategorys->links('vendor.pagination.default') }}
