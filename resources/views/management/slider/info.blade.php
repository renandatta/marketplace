@extends('layouts.management')

@section('title')
    Informasi Toko
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.min.css') }}">
    <style>
        .dropify-wrapper .dropify-message p{
            font-size: 12pt;
        }
    </style>
@endpush

@section('content')
    <h4>{{ empty($slider) ? 'Tambah' : 'Ubah' }} Toko</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('management.slider.save') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if(!empty($slider))
                    <input type="hidden" name="id" value="{{ $slider->id }}">
                @endif
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', !empty($slider) ? $slider->name : '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Foto Produk</label>
                            <input type="file" class="dropify" name="image" id="image" @if(!empty($slider)) data-default-file="{{ $slider->image_location }}" @endif>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('management.slider') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
        @if(!empty($slider))
            <div class="card-footer text-right">
                <form action="{{ route('management.slider.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $slider->id }}">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endpush
