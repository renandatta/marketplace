<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th>Keterangan</th>
        <th>Instruksi Pembayaran</th>
        <th width="100px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($paymentTypes as $key => $paymentType)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $paymentType->name }}</td>
            <td>{{ $paymentType->description }}</td>
            <td style="white-space: break-spaces;">{!! $paymentType->instruction !!}</td>
            <td class="text-center">
                <a href="{{ route('management.payment_type.info', 'id=' . $paymentType->id) }}"><i class="fa fa-edit"></i> Ubah</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $paymentTypes->links('vendor.pagination.default') }}
