@extends('layouts.management')

@section('title')
    Informasi Produk Kategori
@endsection

@section('content')
    <h4>{{ empty($productCategory) ? 'Tambah' : 'Ubah' }} Produk Kategori</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('management.product_category.save') }}" method="post">
                @csrf
                @if(!empty($productCategory))
                    <input type="hidden" name="id" value="{{ $productCategory->id }}">
                @endif
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', !empty($productCategory) ? $productCategory->name : '') }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Keterangan</label>
                    <textarea name="description" id="description" rows="4" class="form-control">{!! old('name', !empty($productCategory) ? $productCategory->description : '') !!}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('management.product_category') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
        @if(!empty($productCategory))
            <div class="card-footer text-right">
                <form action="{{ route('management.product_category.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $productCategory->id }}">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        @endif
    </div>
@endsection
