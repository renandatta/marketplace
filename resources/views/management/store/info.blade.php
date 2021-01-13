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
    <h4>{{ empty($store) ? 'Tambah' : 'Ubah' }} Toko</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('management.store.save') }}" method="post">
                @csrf
                @if(!empty($store))
                    <input type="hidden" name="id" value="{{ $store->id }}">
                @endif
                <div class="row">
                        <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', !empty($store) ? $store->name : '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">No.Telp</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', !empty($store) ? $store->phone : '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', !empty($store) ? $store->email : '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="province">{{ __('model.province') }}</label>
                            <select name="province" id="province" class="form-control select2">
                                <option value="">-</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->province }}" data-id="{{ $province->province_id }}" @if(!empty($store) && $store->province == $province->province) selected @endif>{{ $province->province }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="province_id" id="province_id">
                        </div>
                        <div class="form-group">
                            <label for="city">{{ __('model.city') }}</label>
                            <select name="city" id="city" class="form-control select2">
                                <option value="">-</option>
                            </select>
                            <input type="hidden" name="city_id" id="city_id">
                        </div>
                        <div class="form-group">
                            <label for="store_level_id">Level</label>
                            <select name="store_level_id" id="store_level_id" class="form-control select2">
                                <option value="">-</option>
                                @foreach($storeLevels as $storeLevel)
                                    <option value="{{ $storeLevel->id }}" @if(!empty($store) && $store->store_level_id == $storeLevel->id) selected @endif>{{ $storeLevel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('management.store') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
        <div class="card-footer text-right">
            @if(!empty($store))
                <form action="{{ route('management.store.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $store->id }}">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('.dropify').dropify();

        let selectedCity = '{{ !empty($store) ? $store->city : '' }}';
        $('#province').change(function () {
            let id = $('#province').find('option:selected').attr('data-id');
            $('#province_id').val(id);
            let city = $('#city');
            city.html('<option value="">-</option>');
            if (id !== '') {
                city.html('<option value="">Loading ...</option>');
                $.post("{{ route('user.city.search') }}", {
                    _token: '{{ csrf_token() }}',
                    province_id: id
                }, function (result) {
                    city.html('<option value="">-</option>');
                    $.each(result, function (i, value) {
                        let selected = (selectedCity == value.city_name) ? 'selected' : '';
                        city.append('<option value="'+ value.city_name +'" data-id="'+ value.city_id +'" '+ selected +'>'+ value.city_name +'</option>');
                    });
                    $('#city').trigger('change');
                });
            }
        });
        $('#city').change(function () {
            let id = $('#city').find('option:selected').attr('data-id');
            $('#city_id').val(id);
        });
        if (selectedCity !== '') $('#province').trigger('change');
    </script>
@endpush
