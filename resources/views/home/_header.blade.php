@php($category = $category ?? null)
@php($product = $product ?? null)

<div class="page-header">
    <div class="page-header__container container">
        <div class="page-header__breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('/') }}">{{ __('layout.home') }}</a>
                        <i class="fa fa-angle-right breadcrumb-arrow"></i>
                    </li>
                    @if($category != null && !empty($category->parent))
                        <li class="breadcrumb-item">
                            <a href="{{ route('category', $category->parent->slug) }}">{{ $category->parent->name }}</a>
                            <i class="fa fa-angle-right breadcrumb-arrow"></i>
                        </li>
                    @endif
                    @if($product != null)
                        <li class="breadcrumb-item">
                            <a href="{{ route('store', $product->store->slug) }}">{{ $product->store->name }}</a>
                            <i class="fa fa-angle-right breadcrumb-arrow"></i>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
        <div class="page-header__title"><h1>{{ $title }}</h1></div>
    </div>
</div>
