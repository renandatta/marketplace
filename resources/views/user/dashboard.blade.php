@extends('layouts.home')

@section('content')
    <div class="site__body">
        @include('user._header')
        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-3 d-flex">
                        @include('user._sidebar')
                    </div>
                    <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                        <div class="dashboard">
                            <div class="dashboard__profile card profile-card">
                                <div class="card-body profile-card__body">
                                    <div class="profile-card__avatar"><img src="{{ Auth::user()->photo_location }}" alt="" /></div>
                                    <div class="profile-card__name">{{ Auth::user()->name }}</div>
                                    <div class="profile-card__email">{{ Auth::user()->email }}</div>
                                    <div class="profile-card__edit">
                                        <a href="{{ route('user.edit_profile') }}" class="btn btn-secondary btn-sm">{{ __('layout.edit_profile') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard__address card address-card address-card--featured">
                                <div class="address-card__badge">{{ __('layout.default_address') }}</div>
                                <div class="address-card__body">
                                    @if(!empty(Auth::user()->default_address))
                                        @php($default_address = Auth::user()->default_address)
                                        <div class="address-card__name">{{ $default_address->name }}</div>
                                        <div class="address-card__row">
                                            {{ $default_address->address }}<br />
                                            {{ $default_address->district. ', '. $default_address->city }}<br />
                                            {{ $default_address->province }}
                                            {{ $default_address->postal_code }}
                                        </div>
                                        <div class="address-card__row">
                                            <div class="address-card__row-title">{{ __('model.phone') }}</div>
                                            <div class="address-card__row-content">{{ $default_address->phone }}</div>
                                        </div>
                                    @else
                                        <h4 class="mt-4">{{ __('layout.default_address_not_found') }}</h4>
                                    @endif
                                    <div class="address-card__footer"><a href="{{ route('user.address') }}">{{ __('layout.edit_address') }}</a></div>
                                </div>
                            </div>
                            <div class="dashboard__orders card">
                                <div class="card-header"><h5>Transaksi Baru</h5></div>
                                <div class="card-divider"></div>
                                <div class="card-table">
                                    <div class="table-responsive-sm">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>{{ __('model.no_order') }}</th>
                                                <th>{{ __('model.date') }}</th>
                                                <th>{{ __('model.status') }}</th>
                                                <th>{{ __('model.detail') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($recentPurchases as $recentPurchase)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('order.detail', 'no_order=' . $recentPurchase->no_purchase) }}">#{{ $recentPurchase->no_purchase }}</a>
                                                    </td>
                                                    <td class="text-nowrap">{{ fulldate($recentPurchase->created_at) }}</td>
                                                    <td>{{ $recentPurchase->status_list[0]->status }}</td>
                                                    <td>
                                                        {{ count($recentPurchase->details) }} {{ __('model.product') }},
                                                        {{ __('model.total') }} Rp. {{ format_number($recentPurchase->details->sum('total_price')) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
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
