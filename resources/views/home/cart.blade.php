@extends('layouts.home')

@section('title')
    Cart
@endsection

@push('styles')
    <style>
        .form-control+.select2-container {
            width: 100%!important;
        }
    </style>
@endpush

@section('content')
    <div class="site__body">
        <div class="page-header">
            <div class="page-header__container container">
                <div class="page-header__breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('/') }}">Home</a>
                                <i class="fa fa-angle-right breadcrumb-arrow"></i>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('layout.cart') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="page-header__title"><h1>{{ __('layout.cart') }}</h1></div>
            </div>
        </div>
        <div class="cart block">
            <div class="container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <table class="cart__table cart-table">
                    <thead class="cart-table__head">
                    <tr class="cart-table__row">
                        <th class="cart-table__column cart-table__column--image">{{ __('model.image') }}</th>
                        <th class="cart-table__column cart-table__column--product">{{ __('model.product') }}</th>
                        <th class="cart-table__column cart-table__column--price">{{ __('model.price') }}</th>
                        <th class="cart-table__column cart-table__column--quantity">{{ __('model.qty') }}</th>
                        <th class="cart-table__column cart-table__column--total">{{ __('model.total') }}</th>
                        <th class="cart-table__column cart-table__column--remove"></th>
                    </tr>
                    </thead>
                    <tbody class="cart-table__body">
                    @php($storeId = '')
                    @php($weights = [])
                    @php($stores = [])
                    @php($storeIds = [])
                    @foreach($carts as $cart)
                        @if($cart->product->store_id != $storeId)
                            @php(array_push($stores, $cart->product->store))
                            @php(array_push($storeIds, $cart->product->store_id))
                            @php($weights[$cart->product->store_id] = 0)
                            <tr class="cart-table__row">
                                <td class="cart-table__column cart-table__column--product" colspan="3">
                                    <a href="{{ route('store', $cart->product->store->slug) }}" class="wishlist__product-name">{{ __('model.store') }} : {{ $cart->product->store->name }}</a>
                                </td>
                                <td class="cart-table__column cart-table__column--product text-right p-1" colspan="3">
                                    <select name="courier_id[]" id="courier_id_{{ $cart->product->store_id }}" class="form-control select2" onchange="countShippingCost('{{ $cart->product->store_id }}')" required>
                                        <option value="" selected disabled>Loading ...</option>
                                    </select>
                                </td>
                            </tr>
                        @endif
                        <tr class="cart-table__row">
                            <td class="cart-table__column cart-table__column--image">
                                <a href="{{ route('product', $cart->product->slug) }}" class="product-image__body">
                                    <img class="product-image__img" src="{{ $cart->product->images[0]->location }}" alt="" />
                                </a>
                            </td>
                            <td class="cart-table__column cart-table__column--product">
                                <a href="{{ route('product', $cart->product->slug) }}" class="wishlist__product-name">{{ $cart->product->name }}</a>
                            </td>
                            <td class="cart-table__column cart-table__column--price" data-title="Price">Rp.{{ format_number($cart->product->price) }}</td>
                            <td class="cart-table__column cart-table__column--quantity" data-title="Quantity">
                                <div class="input-number">
                                    <input class="form-control input-number__input" id="qty_{{ $cart->id }}" type="number" min="1" value="{{ $cart->qty }}" />
                                    <div class="input-number__add" data-id="{{ $cart->id }}"></div>
                                    <div class="input-number__sub" data-id="{{ $cart->id }}"></div>
                                </div>
                            </td>
                            <td class="cart-table__column cart-table__column--total" data-title="Total">Rp.{{ format_number($cart->total_price) }}</td>
                            <td class="cart-table__column cart-table__column--remove">
                                <form action="{{ route('cart.delete') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $cart->id }}">
                                    <button type="submit" class="btn btn-light btn-sm btn-svg-icon">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @php($weights[$cart->store_id] += ($cart->product->weight * $cart->qty))
                        @php($storeId = $cart->product->store_id)
                    @endforeach
                    </tbody>
                </table>
                <div class="row justify-content-end pt-5">
                    <div class="col-12 col-md-7 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">{{ __('layout.cart') }} {{ __('model.total') }}</h3>
                                <table class="cart__totals">
                                    <thead class="cart__totals-header">
                                    <tr>
                                        <th>{{ __('layout.sub_total') }}</th>
                                        <td>Rp.{{ format_number($carts->sum('total_price')) }}</td>
                                    </tr>
                                    </thead>
                                    <tbody class="cart__totals-body">
                                    <tr>
                                        <th>{{ __('layout.shipping') }}</th>
                                        <td id="shipping_cost">
                                            @if(!empty(Auth::user()->default_address))
                                                Rp.0
                                            @else
                                                {{ __('layout.address_alert') }}
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot class="cart__totals-footer">
                                    <tr>
                                        <th>{{ __('model.total') }}</th>
                                        <td id="total_price">Rp.{{ format_number($carts->sum('total_price')) }}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                                @if(!empty(Auth::user()->default_address))
                                    <form action="{{ route('checkout.save') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="stores" value="{!! json_encode($storeIds) !!}">
                                        <input type="hidden" name="courier_services" id="courier_services" value="">
                                        <input type="hidden" name="shipping_cost" id="shipping_cost_form" value="0">
                                        <button type="submit" class="btn btn-primary btn-xl btn-block cart__checkout-button" id="button_checkout">Lanjut ke Pembayaran</button>
                                    </form>
                                @else
                                    <a class="btn btn-secondary btn-xl btn-block cart__checkout-button" href="{{ route('user.address.new') }}">{{ __('layout.no_default_address') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.input-number__add, .input-number__sub').click(function () {
            let id = $(this).attr('data-id');
            let qty = $('#qty_' + id).val();
            $.post("{{ route('cart.update') }}", {
                _token: '{{ csrf_token() }}',
                id: id,
                qty: qty
            }, function () {
                window.location.reload();
            }).fail(function (xhr) {
                console.log(xhr.responseText());
            });
        });

        @if(!empty(Auth::user()->default_address))
            let shippingCost = [];
            let courierServices = [];
            @foreach($stores as $store)
                shippingCost.push({id: parseInt('{{ $store->id }}'), cost: 0});
                $.post("{{ route('shipping.cost') }}", {
                    _token: '{{ csrf_token() }}',
                    store_id: '{{ $store->id }}',
                    weight: parseFloat('{{ $weights[$store->id] }}')
                }, function (result) {
                    let select = $('#courier_id_{{ $store->id }}');
                    select.html('<option value="" selected disabled>{{ __('layout.select_service') }}</option>>');
                    $.each(result[0].costs, function (i, value) {
                        select.append('<option value="'+ value.service +'" data-price="'+ value.cost[0].value +'">'+ value.service +', '+ value.cost[0].etd +', '+ add_commas(value.cost[0].value) +'</option>');
                    });
                }).fail(function (xhr) {
                    console.log(xhr.responseText);
                });
            @endforeach


            function countShippingCost(store_id) {
                let index = false;
                $.each(shippingCost, function (i, value) {
                    if (value.id === parseInt(store_id)) index = i;
                });

                let cost = $('#courier_id_' + store_id).find('option:selected').attr('data-price');
                shippingCost[index].cost = cost;

                let totalShippingCost = 0;
                $.each(shippingCost, function (i, value) {
                    totalShippingCost += parseFloat(value.cost);
                });
                $('#shipping_cost').html('Rp.' + add_commas(totalShippingCost));
                $('#shipping_cost_form').val(totalShippingCost);

                let index2 = null;
                $.each(courierServices, function (i, value) {
                    if (parseInt(value.id) === parseInt(store_id)) index2 = i;
                });
                let service = $('#courier_id_' + store_id).find('option:selected').val();
                if (index2 === null) {
                    courierServices.push({id: store_id, value: service, cost: cost});
                } else {
                    courierServices[index2].value = service;
                    courierServices[index2].cost = cost;
                }
                $('#courier_services').val(JSON.stringify(courierServices));
            }
        @endif
    </script>
@endpush
