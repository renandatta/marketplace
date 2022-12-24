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
                            <div class="card-header"><h5>{{ __('layout.edit_profile') }}</h5></div>
                            <div class="card-divider"></div>
                            <div class="card-body">
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-7 col-xl-6">
                                        <form action="{{ route('user.save_profile') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @php($user = Auth::user())
                                            <div class="form-group">
                                                <label for="name">{{ __('model.name') }}</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $user->name }}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="email">{{ __('model.email') }}</label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ $user->email }}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="photo">{{ __('model.photo') }}</label>
                                                <input type="file" class="dropify" id="photo" name="photo" data-default-file="{{ Auth::user()->photo_location }}" />
                                            </div>
                                            <div class="form-group mt-5 mb-0"><button type="submit" class="btn btn-primary">{{ __('layout.update_profile') }}</button></div>
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
    </script>
@endpush
