@extends('layouts.home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.min.css') }}">
    <style>
        .dropify-wrapper .dropify-message p{
            font-size: 12pt;
        }
    </style>
@endpush

@section('content')
    <div class="site__body">
        @include('user._header')
        <div class="block">
            <div class="container">
                @include('user._alert')
                <div class="row">
                    <div class="col-12 col-lg-3 d-flex">
                        @include('user._sidebar')
                    </div>
                    <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                        <div class="card">
                            <div class="card-header"><h5>{{ __('layout.new_address') }}</h5></div>
                            <div class="card-divider"></div>
                            <div class="card-body">
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-7 col-xl-6">
                                        <form action="{{ route('user.address.save') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ !empty($address) ? $address->id : '' }}">
                                            <div class="form-group">
                                                <label for="name">{{ __('model.name') }}</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ !empty($address) ? $address->name : '' }}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="address">{{ __('model.address') }}</label>
                                                <input type="text" class="form-control" id="address" name="address" value="{{ !empty($address) ? $address->address : '' }}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="postal_code">{{ __('model.postal_code') }}</label>
                                                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ !empty($address) ? $address->postal_code : '' }}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="province">{{ __('model.province') }}</label>
                                                <select name="province" id="province" class="form-control select2">
                                                    <option value="">-</option>
                                                    @foreach($provinces as $province)
                                                        <option value="{{ $province->province }}" data-id="{{ $province->province_id }}" @if(!empty($address) && $address->province == $province->province) selected @endif>{{ $province->province }}</option>
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
                                                <label for="district">{{ __('model.district') }}</label>
                                                <input type="text" class="form-control" id="district" name="district" value="{{ !empty($address) ? $address->district : '' }}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">{{ __('model.phone') }}</label>
                                                <input type="text" class="form-control" id="phone" name="phone" value="{{ !empty($address) ? $address->phone : '' }}" />
                                            </div>
                                            <div class="form-group mt-5 mb-0"><button type="submit" class="btn btn-primary">{{ __('layout.save_address') }}</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('.dropify').dropify();

        let selectedCity = '{{ !empty($address) ? $address->city : '' }}';
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
