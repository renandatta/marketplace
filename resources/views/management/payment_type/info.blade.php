@extends('layouts.management')

@section('title')
    Informasi Metode Pembayaran
@endsection

@section('content')
    <h4>{{ empty($paymentType) ? 'Tambah' : 'Ubah' }} Metode Pembayaran</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('management.payment_type.save') }}" method="post">
                @csrf
                @if(!empty($paymentType))
                    <input type="hidden" name="id" value="{{ $paymentType->id }}">
                @endif
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', !empty($paymentType) ? $paymentType->name : '') }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Keterangan</label>
                    <textarea name="description" id="description" rows="4" class="form-control" required>{!! old('name', !empty($paymentType) ? $paymentType->description : '') !!}</textarea>
                </div>
                <div class="form-group">
                    <label for="instruction">Instruksi Pembayaran</label>
                    <textarea name="instruction" id="instruction" rows="10" class="form-control" required>{!! old('name', !empty($paymentType) ? $paymentType->instruction : '') !!}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('management.payment_type') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
        @if(!empty($paymentType))
            <div class="card-footer text-right">
                <form action="{{ route('management.payment_type.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $paymentType->id }}">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        @endif
    </div>
@endsection
