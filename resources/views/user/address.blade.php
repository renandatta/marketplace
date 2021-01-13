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
                        <div class="addresses-list">
                            <a href="{{ route('user.address.new') }}" class="addresses-list__item addresses-list__item--new">
                                <div class="addresses-list__plus"></div>
                                <div class="btn btn-secondary btn-sm">Add New</div>
                            </a>
                            <div class="addresses-list__divider"></div>
                            @foreach($addresses as $address)
                            <div class="addresses-list__item card address-card">
                                @if($address->is_default == 1)
                                    <div class="address-card__badge">Default</div>
                                @endif
                                <div class="address-card__body">
                                    @include('user._address_grid', ['address' => $address])
                                    <div class="address-card__footer">
                                        <a href="{{ route('user.address.edit', 'id=' . $address->id) }}">Edit</a>
                                        &nbsp;&nbsp;
                                        <a href="javascript:void(0)" onclick="document.getElementById('delete_address_{{ $address->id }}').submit()">Remove</a>
                                        @if($address->is_default == 0)
                                            <br><br>
                                            <a href="javascript:void(0)" onclick="document.getElementById('default_address_{{ $address->id }}').submit()">Make Default</a>
                                            <form action="{{ route('user.address.default') }}" method="post" id="default_address_{{ $address->id }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $address->id }}">
                                            </form>
                                        @endif
                                        <form action="{{ route('user.address.delete') }}" method="post" id="delete_address_{{ $address->id }}">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" value="{{ $address->id }}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="addresses-list__divider"></div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
