@extends('layouts.home')

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
                                        <form action="{{ route('user.save_password') }}" method="post">
                                            @csrf
                                            @php($user = Auth::user())
                                            <div class="form-group">
                                                <label for="password">{{ __('model.password') }}</label>
                                                <input type="password" class="form-control" name="password" id="password" />
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">{{ __('model.password_confirm') }}</label>
                                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" />
                                            </div>
                                            <div class="form-group mt-5 mb-0">
                                                <button type="submit" class="btn btn-primary">{{ __('layout.update_profile') }}</button>
                                            </div>
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
