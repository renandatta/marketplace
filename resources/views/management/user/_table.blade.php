<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>User Level</th>
        <th width="100px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $key => $user)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->user_level }}</td>
            <td class="text-center">
                <a href="{{ route('management.user.info', 'id=' . $user->id) }}"><i class="fa fa-edit"></i> Ubah</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $users->links('vendor.pagination.default') }}
