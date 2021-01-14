@extends('layouts.home')

@section('content')
    <div class="site__body">
        <div class="block-slideshow block-slideshow--layout--with-departments block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 d-none d-lg-block"></div>
                    <div class="col-12 col-lg-9">
                        <div class="block-slideshow__body">
                            <div class="owl-carousel">
                                @foreach($sliders as $slider)
                                    <a class="block-slideshow__slide" href="#">
                                        <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop" style="background-image: url('{{ $slider->image_location }}');"></div>
                                        <div class="block-slideshow__slide-image block-slideshow__slide-image--mobile" style="background-image: url('{{ $slider->image_location }}');"></div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block block-products-carousel" data-layout="grid-4" data-mobile-grid-columns="2">
            <div class="container">
                <div class="block-header">
                    <h3 class="block-header__title">{{ __('layout.this_month_special') }}</h3>
                    <div class="block-header__divider"></div>
                    <div class="block-header__arrows-list">
                        <button class="block-header__arrow block-header__arrow--left" type="button">
                            <i class="fa fa-angle-left"></i>
                        </button>
                        <button class="block-header__arrow block-header__arrow--right" type="button">
                            <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                </div>
                <div class="block-products-carousel__slider">
                    <div class="block-products-carousel__preloader"></div>
                    <div class="owl-carousel">
                        @foreach($specials as $special)
                            <div class="block-products-carousel__column">
                                <div class="block-products-carousel__cell">
                                    @include('home._product_grid', ['product' => $special->product])
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="block block--highlighted block-products block-products--layout--large-first" data-mobile-grid-columns="2">
            <div class="container">
                <div class="block-header">
                    <h3 class="block-header__title">{{ __('layout.best_seller') }}</h3>
                    <div class="block-header__divider"></div>
                </div>
                <div class="block-products__body">
                    <div class="block-products__featured">
                        <div class="block-products__featured-item">
                            @if(count($bestSellers) > 0)
                                @include('home._product_grid', ['product' => $bestSellers[0]->product])
                            @endif
                        </div>
                    </div>
                    <div class="block-products__list">
                        @foreach($bestSellers as $key => $bestSeller)
                            @if($key > 0 && $key < 7)
                                <div class="block-products__list-item">
                                    @include('home._product_grid', ['product' => $bestSeller->product])
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="block block-products-carousel" data-layout="horizontal" data-mobile-grid-columns="1">
            <div class="container">
                <div class="block-header">
                    <h3 class="block-header__title">{{ __('layout.for_user') }}</h3>
                    <div class="block-header__divider"></div>
                    <div class="block-header__arrows-list">
                        <button class="block-header__arrow block-header__arrow--left" type="button">
                            <i class="fa fa-angle-left"></i>
                        </button>
                        <button class="block-header__arrow block-header__arrow--right" type="button">
                            <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                </div>
                <div class="block-products-carousel__slider">
                    <div class="block-products-carousel__preloader"></div>
                    <div class="owl-carousel">
                        @foreach($forusers as $foruser)
                            <div class="block-products-carousel__column">
                                <div class="block-products-carousel__cell">
                                    @include('home._product_grid', ['product' => $foruser->product])
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="block block--highlighted block-product-columns d-lg-block d-none">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <div class="block-header">
                            <h3 class="block-header__title">{{ __('layout.favorites') }}</h3>
                            <div class="block-header__divider"></div>
                        </div>
                        <div class="block-product-columns__column">
                            @foreach($favorites as $key => $favorite)
                                @if($key < 6)
                                    <div class="block-product-columns__item">
                                        @include('home._product_grid_small', ['product' => $favorite->product])
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="block-header">
                            <h3 class="block-header__title">{{ __('layout.promotion') }}</h3>
                            <div class="block-header__divider"></div>
                        </div>
                        <div class="block-product-columns__column">
                            @foreach($promotions as $key => $promotion)
                                @if($key < 6)
                                    <div class="block-product-columns__item">
                                        @include('home._product_grid_small', ['product' => $promotion->product])
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
