@extends('layouts.home')

@push('styles')
    <style>
        td{
            vertical-align: top;
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
                            <div class="card-header"><h5>{{ __('layout.order_history') }}</h5></div>
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
                                        @foreach($purchaseHistories as $purchaseHistory)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('order.detail', 'no_order=' . $purchaseHistory->no_purchase) }}">#{{ $purchaseHistory->no_purchase }}</a>
                                                </td>
                                                <td class="text-nowrap">{{ fulldate($purchaseHistory->created_at) }}</td>
                                                <td>{{ $purchaseHistory->status_list[0]->status }}</td>
                                                <td>
                                                    {{ count($purchaseHistory->details) }} {{ __('model.product') }},
                                                    {{ __('model.total') }} Rp. {{ format_number($purchaseHistory->details->sum('total_price')) }}
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
@endsection
