@extends('layouts.home')

@section('title')
    {{ $product->name }} -
@endsection

@section('content')
    <div class="site__body">
        @include('home._header', ['title' => $title, 'product' => $product])
        <div class="block">
            <div class="container">
                <div class="product product--layout--standard" data-layout="standard">
                    @include('home._product_detail', ['product' => $product])
                </div>
                <div class="product-tabs product-tabs--sticky">
                    <div class="product-tabs__list">
                        <div class="product-tabs__list-body">
                            <div class="product-tabs__list-container container">
                                <a href="#tab-description" class="product-tabs__item product-tabs__item--active">{{ __('layout.description') }}</a>
                                <a href="#tab-discussions" class="product-tabs__item">{{ __('layout.discussion') }}</a>
                                <a href="#tab-reviews" class="product-tabs__item">{{ trans_choice('layout.review', 2) }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="product-tabs__content">
                        <div class="product-tabs__pane product-tabs__pane--active" id="tab-description">
                            <div class="typography">
                                <h3 class="mb-3">{{ __('layout.product_full_description') }}</h3>
                                {!! $product->description !!}
                            </div>
                        </div>
                        <div class="product-tabs__pane" id="tab-discussions">
                            <div class="reviews-view">
                                <div class="reviews-view__list">
                                    <h3 class="reviews-view__header">{{ __('layout.discussion') }}</h3>
                                    <div class="reviews-list">
                                        <ol class="reviews-list__content">
                                            @foreach($product->discussions as $discussion)
                                                <li class="reviews-list__item">
                                                    <div class="review">
                                                        <div class="review__content">
                                                            <div class="review__author">{{ $discussion->user->name }}</div>
                                                            <div class="review__text">
                                                                {{ $discussion->content }}
                                                            </div>
                                                            <div class="review__date">{{ fulldate($discussion->created_at) }}</div>
                                                            <ul class="mt-5 pl-5">
                                                                @foreach($discussion->replies as $reply)
                                                                    <li class="reviews-list__item border-bottom-0" style="list-style: none;">
                                                                        <div class="review">
                                                                            <div class="review__content">
                                                                                <div class="review__author">{{ $reply->user->name }}</div>
                                                                                <div class="review__text">
                                                                                    {{ $reply->content }}
                                                                                </div>
                                                                                <div class="review__date">{{ fulldate($reply->created_at) }}</div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-tabs__pane" id="tab-reviews">
                            <div class="reviews-view">
                                <div class="reviews-view__list">
                                    <h3 class="reviews-view__header">{{ __('layout.customer_review') }}</h3>
                                    <div class="reviews-list">
                                        <ol class="reviews-list__content">
                                            @foreach($product->reviews as $review)
                                            <li class="reviews-list__item">
                                                <div class="review">
                                                    <div class="review__avatar"><img src="{{ $review->user->photo }}" alt="" /></div>
                                                    <div class="review__content">
                                                        <div class="review__author">{{ $review->user->name }}</div>
                                                        <div class="review__rating">
                                                            <div class="rating">
                                                                @include('home._rating', ['rating' => $review->rating])
                                                            </div>
                                                        </div>
                                                        <div class="review__text">
                                                            {{ $review->review }}
                                                        </div>
                                                        <div class="review__date">{{ fulldate($review->created_at) }}</div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ol>
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
