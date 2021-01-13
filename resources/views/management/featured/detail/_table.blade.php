<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th width="80px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($featured_details as $key => $detail)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $detail->product->name }}</td>
            <td class="p-0">
                <form action="{{ route('management.featured.detail.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $detail->id }}">
                    <button type="submit" class="btn btn-sm btn-block btn-danger"><i class="fa fa-times"></i> Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $featured_details->links('vendor.pagination.default') }}
