<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th width="80px"></th>
        <th width="80px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($featureds as $key => $featured)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $featured->name }}</td>
            <td class="text-center">
                <a href="{{ route('management.featured.info', 'id=' . $featured->id) }}"><i class="fa fa-edit"></i> Ubah</a>
            </td>
            <td class="text-center">
                <a href="{{ route('management.featured.detail', 'featured_id=' . $featured->id) }}"><i class="fa fa-list"></i> Detail</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $featureds->links('vendor.pagination.default') }}
