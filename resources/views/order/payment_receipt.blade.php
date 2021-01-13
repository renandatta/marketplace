@extends('layouts.home')

@section('title')
    {{ __('layout.detail_order') }}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.min.css') }}">
    <style>
        .dropify-wrapper .dropify-message p{
            font-size: 12pt;
        }
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
                    <div class="card address-card mt-3">
                        <div class="address-card__body">
                            <div class="address-card__badge address-card__badge--muted">Bukti Pembayaran</div>
                            <form action="{{ route('payment_receipt.save') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                <div class="card-body p-1 text-center">
                                    <input type="file" class="dropify" name="image" data-height="400" required>
                                </div>
                                <div class="card-footer p-1">
                                    <button type="submit" class="btn btn-sm btn-block btn-danger">Upload Bukti Pembayaran</button>
                                </div>
                            </form>
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
