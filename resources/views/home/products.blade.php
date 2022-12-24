@extends('layouts.home')

@section('title')
    {{ $title }} -
@endsection

@section('content')
    <div class="site__body">
        @include('home._header', ['title' => $title, 'category' => $category])
        <div class="container">
            <div class="shop-layout shop-layout--sidebar--start">
                <div class="shop-layout__sidebar">
                    <div class="block block-sidebar block-sidebar--offcanvas--mobile">
                        <div class="block-sidebar__backdrop"></div>
                        <div class="block-sidebar__body">
                            <div class="block-sidebar__header">
                                <div class="block-sidebar__title">{{ __('layout.filter') }}</div>
                                <button class="block-sidebar__close" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                            <div class="block-sidebar__item">
                                <div class="widget-filters widget widget-filters--offcanvas--mobile" data-collapse data-collapse-opened-class="filter--opened">
                                    <h4 class="widget-filters__title widget__title">{{ __('layout.filter') }}</h4>
                                    <div class="widget-filters__list">
                                        <div class="widget-filters__item">
                                            @php($categoryCount = isset($productCategories) ? count($productCategories) : 0)
                                            @foreach($productCategories as $productCategory)
                                                @if($category != null && $category->id == $productCategory->id)
                                                    @php($categoryCount = (isset($category) && $category != null) ? count($category->sub) : isset($categoryCount) ? $categoryCount : 0)
                                                @endif
                                                <div class="filter @if($category != null && $category->id == $productCategory->id) filter--opened @endif" data-collapse-item>
                                                    <button type="button" class="filter__title" data-collapse-trigger>
                                                        {{ $productCategory->name }}
                                                        <i class="fa fa-angle-up filter__arrow"></i>
                                                    </button>
                                                    <div class="filter__body" data-collapse-content>
                                                        <div class="filter__container">
                                                            <div class="filter-categories">
                                                                <ul class="filter-categories__list">
                                                                    @foreach($productCategory->sub as $subCategory)
                                                                        <li class="filter-categories__item filter-categories__item--parent">
                                                                            <i class="fa fa-angle-right filter-categories__arrow"></i>
                                                                            <a href="{{ route('category', $subCategory->slug) }}">{{ $subCategory->name }}</a>
                                                                            <div class="filter-categories__counter">{{ $subCategory->product_count }}</div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="widget-filters__item">
                                            <div class="filter filter--opened" data-collapse-item>
                                                <button type="button" class="filter__title" data-collapse-trigger>
                                                    {{ __('model.price') }}
                                                    <i class="fa fa-angle-up filter__arrow"></i>
                                                </button>
                                                <div class="filter__body" data-collapse-content>
                                                    <div class="filter__container">
                                                        <div class="filter-price" data-min="0" data-max="{{ $maxPrice }}" data-from="0" data-to="{{ $maxPrice }}">
                                                            <div class="filter-price__slider"></div>
                                                            <div class="filter-price__title">Price: <br>Rp.<span class="filter-price__min-value"></span> – Rp.<span class="filter-price__max-value"></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="widget-filters__actions d-flex">
                                        <button class="btn btn-primary btn-sm">{{ __('layout.filter') }}</button>
                                        <button class="btn btn-secondary btn-sm">{{ __('layout.reset') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="block-sidebar__item d-none d-lg-block">
                                <div class="widget-products widget">
                                    <h4 class="widget__title">{{ __('layout.latest_product') }}</h4>
                                    <div class="widget-products__list">
                                        @foreach($latestProducts as $latestProduct)
                                        <div class="widget-products__item">
                                            <div class="widget-products__image">
                                                <div class="product-image">
                                                    <a href="{{ route('product', $latestProduct->slug) }}" class="product-image__body">
                                                        <img class="product-image__img" src="{{ $latestProduct->images[0]->image_location }}" alt="" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="widget-products__info">
                                                <div class="widget-products__name"><a href="{{ route('product', $latestProduct->slug) }}">{{ $latestProduct->name }}</a></div>
                                                <div class="widget-products__prices">Rp.{{ format_number($latestProduct->price) }}</div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shop-layout__content">
                    <div class="block">
                        <div class="products-view">
                            <div class="products-view__options">
                                <div class="view-options view-options--offcanvas--mobile">
                                    <div class="view-options__filters-button">
                                        <button type="button" class="filters-button">
                                            <i class="fa fa-filter filters-button__icon"></i>
                                            <span class="filters-button__title">{{ __('layout.filter') }}</span>
                                            <span class="filters-button__counter">{{ $categoryCount }}</span>
                                        </button>
                                    </div>
                                    <div class="view-options__legend">
                                        {{ __('layout.showing') . ' ' . count($products) . ' ' . __('layout.of') . ' ' . $products->total() . ' ' . trans_choice('layout.products', count($products)) }}
                                    </div>
                                    <div class="view-options__divider"></div>
                                    <div class="view-options__control">
                                        <label for="sort_product">Sort By</label>
                                        <div>
                                            <select class="form-control form-control-sm" name="sort_product" id="sort_product">
                                                <option value="">Default</option>
                                                <option value="name_asc">{{ __('model.name') }} (A-Z)</option>
                                                <option value="name_desc">{{ __('model.name') }} (Z-A)</option>
                                                <option value="price_asc">{{ __('model.price') }} ({{ strtolower(__('model.low')) . '-' . strtolower(__('model.high')) }})</option>
                                                <option value="price_desc">{{ __('model.price') }} ({{ strtolower(__('model.high')) . '-' . strtolower(__('model.low')) }})</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="products-view__list products-list" data-layout="grid-3-sidebar" data-with-features="false" data-mobile-grid-columns="2">
                                <div class="products-list__body">
                                    @foreach($products as $product)
                                        <div class="products-list__item">
                                            @include('home._product_grid', ['product' => $product])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

