@extends('layouts.home')

@section('title')
    {{ __('layout.detail_order') }}
@endsection

@push('styles')
    <style>
        .order-success__meta-list {
            justify-content: space-between;
        }
        .order-success__meta-item:not(:last-child):before {
            border: 0;
        }
    </style>
@endpush

@section('content')
    <div class="site__body">
        <div class="block order-success">
            <div class="container">
                <div class="order-success__body">
                    <div class="order-success__header p-3">
                    </div>
                    <div class="order-success__meta">
                        <ul class="order-success__meta-list">
                            <li class="order-success__meta-item text-left">
                                <span class="order-success__meta-title">
                                    {{ __('model.no_order') }}:</span> <span class="order-success__meta-value">#{{ $purchase->no_purchase }}
                                </span>
                            </li>
                            <li class="order-success__meta-item text-right">
                                <span class="order-success__meta-title">
                                    {{ __('model.date') }}:</span> <span class="order-success__meta-value">{{ fulldate($purchase->created_at) }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="order-list">
                            <table>
                                <thead class="order-list__header">
                                <tr>
                                    <th class="order-list__column-label" colspan="2">Product</th>
                                    <th class="order-list__column-quantity">Qty</th>
                                    <th class="order-list__column-total">Total</th>
                                </tr>
                                </thead>
                                <tbody class="order-list__products">
                                @foreach($purchase->details as $detail)
                                <tr>
                                    <td class="order-list__column-image">
                                        <div class="product-image">
                                            <a href="{{ route('product', $detail->product->slug) }}" class="product-image__body"><img class="product-image__img" src="{{ $detail->product->images[0]->location }}" alt="" /></a>
                                        </div>
                                    </td>
                                    <td class="order-list__column-product">
                                        <a href="{{ route('product', $detail->product->slug) }}">{{ $detail->product->name }}</a>
                                        <div class="order-list__options">
                                            <ul class="order-list__options-list">
                                                <li class="order-list__options-item">
                                                    <span class="order-list__options-label">{{ __('model.store') }}:</span>
                                                    <span class="order-list__options-value">{{ $detail->product->store->name }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="order-list__column-quantity" data-title="Qty:">{{ $detail->qty }}</td>
                                    <td class="order-list__column-total">Rp.{{ format_number($detail->total_price) }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tbody class="order-list__subtotals">
                                <tr>
                                    <th class="order-list__column-label" colspan="3">{{ __('layout.sub_total') }}</th>
                                    <td class="order-list__column-total">Rp.{{ format_number($purchase->details->sum('total_price')) }}</td>
                                </tr>
                                <tr>
                                    <th class="order-list__column-label" colspan="3">{{ __('layout.shipping') }}</th>
                                    @php($shipping_cost = 0)
                                    @foreach($purchase->shipping_cost_data as $cost)
                                        @php($shipping_cost += $cost->shipping_cost)
                                    @endforeach
                                    <td class="order-list__column-total">Rp.{{ format_number($shipping_cost) }}</td>
                                </tr>
                                </tbody>
                                <tfoot class="order-list__footer">
                                <tr>
                                    <th class="order-list__column-label" colspan="3">Total</th>
                                    <td class="order-list__column-total">Rp.{{ format_number($purchase->details->sum('total_price') + $shipping_cost) }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3 no-gutters mx-n2">
                        <div class="col-sm-6 col-12 px-2">
                            <div class="card address-card">
                                <div class="address-card__body">
                                    <div class="address-card__badge address-card__badge--muted">{{ __('layout.address') }}</div>
                                    @include('user._address_grid', ['address' => $purchase->user_address])
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12 px-2 mt-sm-0 mt-3">
                            <div class="card address-card">
                                <div class="address-card__body">
                                    <div class="address-card__badge address-card__badge--muted">{{ __('layout.order_status') }}</div>
                                    <br>
                                    @foreach($purchase->status_list as $key => $status)
                                    <div class="address-card__row">
                                        <i class="fa {{ $key == 0 ? 'fa-chevron-right ml-1' : 'fa-minus' }} mr-2"></i> {{ $status->status }} <br>
                                        <small style="font-size: 90%;"><i>{{ $status->description }}</i></small>
                                    </div>
                                    @endforeach

                                    @if(count($purchase->status_list) == 1)
                                        <div class="text-center mt-3">
                                            <a href="{{ route('checkout', 'no_order=' . $purchase->no_purchase) }}" class="btn btn-primary">Proses Pembayaran</a>
                                        </div>
                                    @endif

                                    @if(count($purchase->status_list) == 2 || $purchase->status_list[0]->status == 'Pembayaran Ditolak')
                                        <div class="text-center mt-3">
                                            <a href="{{ route('payment_receipt', 'no_order=' . $purchase->no_purchase) }}" class="btn btn-primary">Upload Bukti Pembayaran</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

