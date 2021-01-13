<div class="product__content">
    <div class="product__gallery">
        <div class="product-gallery">
            <div class="product-gallery__featured">
                <button class="product-gallery__zoom">
                    <i class="fa fa-zoom"></i>
                </button>
                <div class="owl-carousel owl-loaded owl-drag" id="product-image">
                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2430px;">
                            @foreach($product->images as $key => $image)
                                <div class="owl-item @if($key == 0) active @endif">
                                    <div class="product-image product-image--location--gallery">
                                        <a href="{{ $image->location }}" class="product-image__body" target="_blank">
                                            <img class="product-image__img" src="{{ $image->location }}" alt="" />
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="owl-nav disabled">
                        <button type="button" role="presentation" class="owl-prev">
                            <span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span>
                        </button>
                    </div>
                    <div class="owl-dots disabled"></div>
                </div>
            </div>
            <div class="product-gallery__carousel">
                <div class="owl-carousel owl-loaded owl-drag" id="product-carousel">
                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 500px;">
                            @foreach($product->images as $key => $image)
                                <div class="owl-item @if($key == 0) active @endif">
                                    <a href="{{ $image->location }}" class="product-image product-gallery__carousel-item @if($key == 0) product-gallery__carousel-item--active @endif">
                                        <div class="product-image__body"><img class="product-image__img product-gallery__carousel-image" src="{{ $image->location }}" alt="" /></div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="owl-nav disabled">
                        <button type="button" role="presentation" class="owl-prev">
                            <span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span>
                        </button>
                    </div>
                    <div class="owl-dots disabled"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="product__info">
        <div class="product__wishlist-compare">
            <button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip" data-placement="right" title="Wishlist">
                <i class="fa fa-heart"></i>
            </button>
        </div>
        <h1 class="product__name">{{ $product->name }}</h1>
        <div class="product__rating">
            <div class="product__rating-stars">
                <div class="rating">
                    <div class="rating__body">
                        @php($rating = isset($product) ? round($product->rating) : 0)
                        @for($i = 1; $i <= $rating; $i++)
                            <i class="fa fa-star" style="color: #ffd333"></i>
                        @endfor
                        @for($i = $rating; $i < 5; $i++)
                            <i class="fa fa-star" style="color: #eaeaea"></i>
                        @endfor
                    </div>
                </div>
            </div>
            @php($ratingCount = isset($product) ? count($product->reviews) : 0)
            <div class="product-card__rating-legend">{{ $ratingCount }} {{ trans_choice('layout.review', $ratingCount) }}</div>
        </div>
        <div class="product__description">
            {{ Str::limit(strip_tags($product->description), 400) }}
        </div>
        <ul class="product__meta">
            <li class="product__meta-availability">{{ __('layout.availability') }}: <span class="text-success">{{ __('layout.in_stock') }}</span></li>
        </ul>
    </div>
    <div class="product__sidebar">
        <div class="product__availability">Availability: <span class="text-success">In Stock</span></div>
        <div class="product__prices">Rp. {{ format_number($product->price) }}</div>
        <div class="product__options">
            <div class="form-group product__option">
                <label class="product__option-label" for="product-quantity">Quantity</label>
                <div class="product__actions">
                    <div class="product__actions-item">
                        <div class="input-number product__quantity">
                            <input id="product-quantity" class="input-number__input form-control form-control-lg" type="number" min="1" value="1" />
                            <div class="input-number__add"></div>
                            <div class="input-number__sub"></div>
                        </div>
                    </div>
                    <div class="product__actions-item product__actions-item--addtocart">
                        <form action="{{ route('cart.save') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="qty" id="product_qty" value="1">
                            <button class="btn btn-primary btn-lg" type="submit">{{ __('layout.add_to_cart') }}</button>
                        </form>
                    </div>
                    <div class="product__actions-item product__actions-item--wishlist">
                        <form action="{{ route('wishlist.save') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn {{ $product->check_wishlist == true ? 'btn-primary' : 'btn-secondary' }} btn-svg-icon btn-lg" data-toggle="tooltip" title="Wishlist">
                                <i class="fa fa-heart"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('.input-number__add, .input-number__sub').click(function () {
            $('#product_qty').val($('#product-quantity').val());
        });
    </script>
@endpush
