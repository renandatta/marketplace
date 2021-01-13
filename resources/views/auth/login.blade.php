@extends('layouts.home')

@section('title')
    Login -
@endsection

@section('content')
    <div class="site__body pt-5">
        <div class="block mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 d-flex flex-column">
                        <div class="card flex-grow-1 mb-md-0">
                            <div class="card-body">
                                <h3 class="card-title">{{ __('layout.login_caption') }}</h3>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="post" action="{{ route('login.process') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">{{ __('model.email') }}</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="password">{{ __('model.password') }}</label>
                                        <input type="password" class="form-control" name="password" id="password" />
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <span class="form-check-input input-check">
                                                <span class="input-check__body">
                                                    <input class="input-check__input" type="checkbox" id="remember" /> <span class="input-check__box"></span>
                                                    <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="images/sprite.svg#check-9x7"></use></svg>
                                                </span>
                                            </span>
                                            <label class="form-check-label" for="login-remember">{{ __('layout.remember_me') }}</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('layout.login') }}</button>
                                    <br><br>
                                    <p class="text-black-50"><a href="{{ route('register') }}">{{ __('layout.register') }}</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
