<div class="dropcart__products-list">
    @foreach($userCarts as $key => $userCart)
        @if($key < 3)
            <div class="dropcart__product">
                <div class="product-image dropcart__product-image">
                    <a href="{{ route('product', $userCart->product->slug) }}" class="product-image__body"><img class="product-image__img" src="{{ $userCart->product->images[0]->image_location }}" alt="" /></a>
                </div>
                <div class="dropcart__product-info">
                    <div class="dropcart__product-name"><a href="{{ route('product', $userCart->product->slug) }}">{{ $userCart->product->name }}</a></div>
                    <div class="dropcart__product-meta">
                        <span class="dropcart__product-quantity">{{ $userCart->qty }}</span> × <span class="dropcart__product-price">Rp.{{ format_number($userCart->product->price) }}</span>
                    </div>
                </div>
                <form action="{{ route('cart.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $userCart->id }}">
                    <button type="submit" class="dropcart__product-remove btn btn-light btn-sm btn-svg-icon">
                        <i class="fa fa-times"></i>
                    </button>
                </form>
            </div>
        @endif
    @endforeach
        @if(count($userCarts) > 3)
            <div class="dropcart__product text-center p-1">
                <a class="text-black-50" href="{{ route('cart') }}">Lihat Lebih Banyak</a>
            </div>
        @endif
</div>
@if(count($userCarts) > 0)
    <div class="dropcart__totals">
        <table>
            <tr>
                <th>Total</th>
                <td>Rp.{{ format_number($userCarts->sum('total_price')) }}</td>
            </tr>
        </table>
    </div>
    <div class="dropcart__buttons">
        <a class="btn btn-secondary" href="{{ route('cart') }}">{{ __('layout.view_cart') }}</a>
    </div>
@else
    <h5 class="text-center mb-5">{{ __('layout.empty_cart') }}</h5>
@endif
