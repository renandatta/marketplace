@extends('layouts.management')

@section('title')
    Informasi Produk Unggulan
@endsection

@section('content')
    <h4>{{ empty($featured) ? 'Tambah' : 'Ubah' }} Produk Unggulan</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('management.featured.save') }}" method="post">
                @csrf
                @if(!empty($featured))
                    <input type="hidden" name="id" value="{{ $featured->id }}">
                @endif
                <div class="row">
                        <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', !empty($featured) ? $featured->name : '') }}" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('management.featured') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
        <div class="card-footer text-right">
            @if(!empty($featured))
                <form action="{{ route('management.featured.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $featured->id }}">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            @endif
        </div>
    </div>
@endsection
