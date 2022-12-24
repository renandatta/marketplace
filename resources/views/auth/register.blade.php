@extends('layouts.home')

@section('title')
    Register -
@endsection

@section('content')
    <div class="site__body pt-5">
        <div class="block mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 d-flex flex-column">
                        <div class="card flex-grow-1 mb-md-0">
                            <div class="card-body">
                                <h3 class="card-title">{{ __('layout.register') }}</h3>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="post" action="{{ route('register.process') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">{{ __('model.name') }}</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{ __('model.email') }}</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="password">{{ __('model.password') }}</label>
                                        <input type="password" class="form-control" name="password" id="password" />
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">{{ __('model.password_confirm') }}</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" />
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('layout.register') }}</button>
                                    <br><br>
                                    <p class="text-black-50">{{ __('layout.have_account') }} <a href="{{ route('login') }}">Login</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
