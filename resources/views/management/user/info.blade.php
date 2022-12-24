@extends('layouts.management')

@section('title')
    Informasi User
@endsection

@section('content')
    <h4>{{ empty($user) ? 'Tambah' : 'Ubah' }} User</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('management.user.save') }}" method="post">
                @csrf
                @if(!empty($user))
                    <input type="hidden" name="id" value="{{ $user->id }}">
                @endif
                <div class="form-group">
                    <label for="user_level">User Level</label>
                    <select name="user_level" id="user_level" class="form-control select2">
                        <option value="User" @if(!empty($user) && $user->user_level == 'User') selected @endif>User</option>
                        <option value="Administrator" @if(!empty($user) && $user->user_level == 'Administrator') selected @endif>Administrator</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', !empty($user) ? $user->name : '') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email', !empty($user) ? $user->email : '') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" id="password" name="password" @if(empty($user)) required @endif>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Ulangi Password</label>
                    <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" @if(empty($user)) required @endif>
                </div>
                @if(!empty($user)) *) Kosongi Password apabila tidak diubah <br><br> @endif

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('management.user') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
        @if(!empty($user))
            <div class="card-footer text-right">
                <form action="{{ route('management.user.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        @endif
    </div>
@endsection
