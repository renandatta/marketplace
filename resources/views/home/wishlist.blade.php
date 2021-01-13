@extends('layouts.home')

@section('title')
    Wishlist
@endsection

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
                            <li class="breadcrumb-item active" aria-current="page">{{ __('layout.wishlist') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="page-header__title"><h1>{{ __('layout.wishlist') }}</h1></div>
            </div>
        </div>
        <div class="block">
            <div class="container">
                <table class="wishlist">
                    <thead class="wishlist__head">
                    <tr class="wishlist__row">
                        <th class="wishlist__column wishlist__column--image">{{ __('model.image') }}</th>
                        <th class="wishlist__column wishlist__column--product">{{ __('model.product') }}</th>
                        <th class="wishlist__column wishlist__column--stock">{{ __('model.stock_status') }}</th>
                        <th class="wishlist__column wishlist__column--price">{{ __('model.price') }}</th>
                        <th class="wishlist__column wishlist__column--tocart"></th>
                        <th class="wishlist__column wishlist__column--remove"></th>
                    </tr>
                    </thead>
                    <tbody class="wishlist__body">
                    @foreach($wishlists as $key => $wishlist)
                        <tr class="wishlist__row">
                            <td class="wishlist__column wishlist__column--image">
                                <div class="product-image">
                                    <a href="{{ route('product', $wishlist->product->slug) }}" class="product-image__body">
                                        <img class="product-image__img" src="{{ $wishlist->product->images[0]->location }}" alt="" />
                                    </a>
                                </div>
                            </td>
                            <td class="wishlist__column wishlist__column--product">
                                <a href="{{ route('product', $wishlist->product->slug) }}" class="wishlist__product-name">{{ $wishlist->product->name }}</a>
                                <div class="wishlist__product-rating">
                                    <div class="rating">
                                        @include('home._rating', ['rating' => $wishlist->product->rating])
                                    </div>
                                    @php($ratingCount = isset($wishlist->product) ? count($wishlist->product->reviews) : 0)
                                    <div class="product-card__rating-legend">{{ $ratingCount }} {{ trans_choice('layout.review', $ratingCount) }}</div>
                                </div>
                            </td>
                            <td class="wishlist__column wishlist__column--stock">
                                <div class="badge badge-success">{{ $wishlist->product->stock > $wishlist->product->stock_min ? __('model.in_stock') : __('model.sold_out') }}</div>
                            </td>
                            <td class="wishlist__column wishlist__column--price">Rp.{{ format_number($wishlist->product->price) }}</td>
                            <td class="wishlist__column wishlist__column--tocart">
                                <form action="{{ route('cart.save') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $wishlist->product->id }}">
                                    <input type="hidden" name="qty" id="product_qty" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">{{ __('layout.add_to_cart') }}</button>
                                </form>
                            </td>
                            <td class="wishlist__column wishlist__column--remove">
                                <form action="{{ route('wishlist.delete') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $wishlist->id }}">
                                    <button type="submit" class="btn btn-light btn-sm btn-svg-icon">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
