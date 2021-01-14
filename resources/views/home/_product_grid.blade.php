<div class="product-card product-card--hidden-actions">
    <button class="product-card__quickview" type="button" data-target="{{ route('product', [$product->slug, 'quickview=1']) }}">
        <i class="fa fa-expand ml-1 mr-1"></i>
        <span class="fake-svg-icon"></span>
    </button>
    <div class="product-card__image product-image">
        @if(count($product->images) > 0)
            <a href="{{ route('product', $product->slug) }}" class="product-image__body"><img class="product-image__img" src="{{ $product->images[0]->location }}" alt="" /></a>
        @endif
    </div>
    <div class="product-card__info">
        <div class="product-card__name"><a href="{{ route('product', $product->slug) }}">{{ $product->name }}</a></div>
        <div class="product-card__rating">
            <div class="product-card__rating-stars">
                <div class="rating">
                    @include('home._rating', ['rating' => $product->rating])
                </div>
            </div>
            @php($ratingCount = isset($product) ? count($product->reviews) : 0)
            <div class="product-card__rating-legend">{{ $ratingCount }} {{ trans_choice('layout.review', $ratingCount) }}</div>
        </div>
    </div>
    <div class="product-card__actions">
        <div class="product-card__availability">Availability: <span class="text-success">In Stock</span></div>
        <div class="product-card__prices">Rp. {{ format_number($product->price) }}</div>
        <div class="product-card__buttons">
            <form action="{{ route('cart.save') }}" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="qty" id="product_qty" value="1">
                <button class="btn btn-primary product-card__addtocart" type="submit">{{ __('layout.add_to_cart') }}</button>
            </form>
            <form action="{{ route('wishlist.save') }}" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button class="btn {{ $product->check_wishlist == true ? 'btn-primary' : 'btn-light' }}" type="submit">
                    <i class="fa fa-heart"></i>
                </button>
            </form>
        </div>
    </div>
</div>
