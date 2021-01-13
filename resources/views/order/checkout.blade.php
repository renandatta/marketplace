@extends('layouts.home')

@section('title')
    Pembayaran Pembelian
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
                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="card-title">Detail Pesanan</h3>
                        <table class="checkout__totals">
                            <thead class="checkout__totals-header">
                            <tr>
                                <th>Produk</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody class="checkout__totals-products">
                                @foreach($details as $detail)
                                <tr>
                                    <td>{{ $detail->product->name }} × {{ $detail->qty }}</td>
                                    <td>Rp.{{ format_number($detail->total_price) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tbody class="checkout__totals-subtotals">
                            <tr>
                                <th>Subtotal</th>
                                <td>Rp.{{ format_number($details->sum('total_price')) }}</td>
                            </tr>
                            <tr>
                                <th>Biaya Pengiriman</th>
                                <td>Rp.{{ format_number($purchase->shipping_cost) }}</td>
                            </tr>
                            <tr>
                                <th>Kode Unit Pembayaran</th>
                                @php($unique = mt_rand(000, 999))
                                <td>Rp.{{ $unique }}</td>
                            </tr>
                            </tbody>
                            <tfoot class="checkout__totals-footer">
                            <tr>
                                <th>Total</th>
                                <td>Rp.{{ format_number($details->sum('total_price') + $purchase->shipping_cost + intval($unique)) }}</td>
                            </tr>
                            </tfoot>
                        </table>
                        <form action="{{ route('payment.save') }}" method="post">
                            @csrf
                            <input type="hidden" name="unique_code" value="{{ $unique }}">
                            <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                            <h4>Metode Pembayaran</h4>
                            <div class="payment-methods">
                                <ul class="payment-methods__list">
                                    @foreach($paymentTypes as $key => $value)
                                    <li class="payment-methods__item">
                                        <label class="payment-methods__item-header">
                                            <span class="payment-methods__item-radio input-radio">
                                                <span class="input-radio__body">
                                                    <input class="input-radio__input" name="payment_type_id" value="{{ $value->id }}" type="radio" required />
                                                    <span class="input-radio__circle"></span>
                                                </span>
                                            </span>
                                            <span class="payment-methods__item-title">{{ $value->name }}</span>
                                        </label>
                                        <div class="payment-methods__item-container">
                                            <div class="payment-methods__item-description text-muted">
                                                {!! $value->description !!}
                                                <br>
                                                {!! $value->instruction !!}
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="submit" class="btn btn-primary btn-xl btn-block">Proses Pembayaran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('[name="payment_type_id"]').on('change', function () {
            const currentItem = $(this).closest('.payment-methods__item');

            $(this).closest('.payment-methods__list').find('.payment-methods__item').each(function (i, element) {
                const links = $(element);
                const linksContent = links.find('.payment-methods__item-container');

                if (element !== currentItem[0]) {
                    const startHeight = linksContent.height();

                    linksContent.css('height', startHeight + 'px');
                    links.removeClass('payment-methods__item--active');
                    linksContent.height(); // force reflow

                    linksContent.css('height', '');
                } else {
                    const startHeight = linksContent.height();

                    links.addClass('payment-methods__item--active');

                    const endHeight = linksContent.height();

                    linksContent.css('height', startHeight + 'px');
                    linksContent.height(); // force reflow
                    linksContent.css('height', endHeight + 'px');
                }
            });
        });
    </script>
@endpush

