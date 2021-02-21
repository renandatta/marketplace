<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th>Keterangan</th>
        <th width="200px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($productCategorys as $key => $productCategory)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>@if($productCategory->parent_code != '#') &nbsp; - @endif {{ $productCategory->name }}</td>
            <td>{{ $productCategory->description }}</td>
            <td class="text-right">
                @if($productCategory->parent_code == '#')
                    <a href="{{ route('management.product_category.info', 'parent_code=' . $productCategory->code) }}"><i class="fa fa-edit"></i> Tambah Sub</a>
                @endif
                <a href="{{ route('management.product_category.info', 'id=' . $productCategory->id) }}"><i class="fa fa-edit"></i> Ubah</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $productCategorys->links('vendor.pagination.default') }}
