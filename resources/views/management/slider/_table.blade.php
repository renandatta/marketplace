<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th>Gambar</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($sliders as $key => $slider)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $slider->name }}</td>
            <td class="p-0">
                <a href="{{ $slider->image_location }}" target="_blank">
                    <img src="{{ $slider->image_location }}" alt="" class="img-fluid" style="height: 30px">
                </a>
            </td>
            <td class="text-center" width="100px">
                <a href="{{ route('management.slider.info', 'id=' . $slider->id) }}"><i class="fa fa-edit"></i> Ubah</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $sliders->links('vendor.pagination.default') }}
