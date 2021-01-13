@extends('layouts.management')

@section('title')
    Informasi Kurir Pengiriman
@endsection

@section('content')
    <h4>{{ empty($courier) ? 'Tambah' : 'Ubah' }} Kurir Pengiriman</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('management.courier.service.save') }}" method="post">
                @csrf
                <input type="hidden" name="courier_id" value="{{ !empty($courierId) ? $courierId : $courier->courier_id }}">
                @if(!empty($courier))
                    <input type="hidden" name="id" value="{{ $courier->id }}">
                @endif
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', !empty($courier) ? $courier->name : '') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('management.courier.service', 'courier_id=' . $courierId) }}" class="btn btn-link">Batal</a>
            </form>
        </div>
        @if(!empty($courier))
            <div class="card-footer text-right">
                <form action="{{ route('management.courier.service.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $courier->id }}">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        @endif
    </div>
@endsection

