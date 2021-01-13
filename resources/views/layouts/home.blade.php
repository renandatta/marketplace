@php($search_keyword = $search_keyword ?? '')
@php($search_category = $search_category ?? '')

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="format-detection" content="telephone=no" />
    <title>@yield('title'){{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <!-- fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i" />
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/assets/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/photoswipe/photoswipe.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/photoswipe/default-skin/default-skin.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <!-- font - fontawesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}" />
    <!-- font - stroyka -->
    <link rel="stylesheet" href="{{ asset('fonts/stroyka/stroyka.css') }}" />
    <style>
        .site-header, .nav-panel, .mobile-header__panel {
            background-color: {{ env('HEADER_COLOR') }};
        }
        .departments__body {
            box-shadow: 0 0 0 2px {{ env('SECONDARY_COLOR') }}
        }
        .btn-primary, .btn-primary.disabled, .btn-primary:disabled {
            background-color: {{ env('SECONDARY_COLOR') }};
            border-color: {{ env('SECONDARY_COLOR') }};
        }
        .totop__button {
            background-color: {{ env('SECONDARY_COLOR') }};
        }
        .departments__button-arrow {
            top: 32%;
        }
        .filter__arrow, .filter-categories__arrow {
            top: 24%;
        }
        .breadcrumb-arrow {
            top: 3px;
        }
        .alert ul {
            margin-bottom: 0;
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="site">
    <header class="site__header d-lg-none">
        <div class="mobile-header mobile-header--sticky" data-sticky-mode="pullToShow">
            <div class="mobile-header__panel">
                <div class="container">
                    <div class="mobile-header__body">
                        <button class="mobile-header__menu-button">
                            <i class="fa fa-bars text-white"></i>
                        </button>
                        <a class="mobile-header__logo" href="{{ route('/') }}">
                            <!-- mobile-logo -->
                            <img src="{{ asset('images/logo.jpg') }}" alt="" class="img-fluid" style="height: 35px">
                            <!-- mobile-logo / end -->
                        </a>
                        <div class="search search--location--mobile-header mobile-header__search">
                            <div class="search__body">
                                <form class="search__form" action="{{ route('search.post') }}" method="post">
                                    @csrf
                                    <input class="search__input" name="search" placeholder="{{ __('layout.search') }}" aria-label="Site search" type="text" autocomplete="off" value="{{ $search_keyword }}" />
                                    <button class="search__button search__button--type--submit" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <button class="search__button search__button--type--close" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <div class="search__border"></div>
                                </form>
                                <div class="search__suggestions suggestions suggestions--location--mobile-header"></div>
                            </div>
                        </div>
                        <div class="mobile-header__indicators">
                            <div class="indicator indicator--mobile-search indicator--mobile d-md-none">
                                <button class="indicator__button">
                                    <span class="indicator__area">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </button>
                            </div>
                            @auth
                                <div class="indicator indicator--mobile">
                                    <a href="{{ route('user') }}" class="indicator__button">
                                    <span class="indicator__area">
                                        <i class="fa fa-user"></i>
                                        <span class="indicator__value" id="transaction_indicator">0</span>
                                    </span>
                                    </a>
                                </div>
                                <div class="indicator indicator--mobile">
                                    <a href="{{ route('wishlist') }}" class="indicator__button">
                                        <span class="indicator__area">
                                            <i class="fa fa-heart"></i>
                                            <span class="indicator__value" id="wishlist_indicator">0</span>
                                        </span>
                                    </a>
                                </div>
                                <div class="indicator indicator--mobile">
                                    <a href="{{ route('cart') }}" class="indicator__button">
                                        <span class="indicator__area">
                                            <i class="fa fa-shopping-cart"></i>
                                            <span class="indicator__value" id="cart_indicator">0</span>
                                        </span>
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <header class="site__header d-lg-block d-none">
        <div class="site-header">
            <div class="site-header__middle container">
                <div class="site-header__logo">
                    <a href="{{ route('/') }}">
                        <!-- logo -->
                        <img src="{{ asset('images/logo.jpg') }}" alt="" class="img-fluid">
                        <!-- logo / end -->
                    </a>
                </div>
                <div class="site-header__search">
                    <div class="search search--location--header">
                        <div class="search__body">
                            <form class="search__form" action="{{ route('search.post') }}" method="post">
                                @csrf
                                <select class="search__categories" aria-label="Category" name="category">
                                    <option value="all">All Categories</option>
                                    @foreach($productCategories as $productCategory)
                                        <option value="{{ $productCategory->slug }}" @if($productCategory->slug == $search_category) selected @endif>{{ $productCategory->name }}</option>
                                    @endforeach
                                </select>
                                <input class="search__input" name="search" placeholder="{{ __('layout.search') }}" aria-label="Site search" type="text" autocomplete="off" value="{{ $search_keyword }}" />
                                <button class="search__button search__button--type--submit" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                                <div class="search__border"></div>
                            </form>
                            <div class="search__suggestions suggestions suggestions--location--header"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-header__nav-panel">
                <!-- data-sticky-mode - one of [pullToShow, alwaysOnTop] -->
                <div class="nav-panel nav-panel--sticky" data-sticky-mode="pullToShow">
                    <div class="nav-panel__container container">
                        <div class="nav-panel__row">
                            <div class="nav-panel__departments">
                                <!-- .departments -->
                                <div class="departments @if(isset($homeCategoryOpen)) departments--open departments--fixed @endif" @if(isset($homeCategoryOpen)) data-departments-fixed-by=".block-slideshow" @endif>
                                    <div class="departments__body">
                                        <div class="departments__links-wrapper">
                                            <div class="departments__submenus-container"></div>
                                            <ul class="departments__links">
                                                @foreach($productCategories as $productCategory)
                                                <li class="departments__item"><a class="departments__item-link" href="{{ route('category', $productCategory->slug) }}">{{ $productCategory->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <button class="departments__button">
                                        <i class="fa fa-bars departments__button-icon"></i> {{ __('layout.product_category') }}
                                        <i class="fa fa-angle-down departments__button-arrow"></i>
                                    </button>
                                </div>
                                <!-- .departments / end -->
                            </div>
                            <div class="nav-panel__indicators">
                                @auth
                                    <div class="indicator">
                                        <a href="{{ route('wishlist') }}" class="indicator__button">
                                            <span class="indicator__area">
                                                <i class="fa fa-heart"></i> <span class="indicator__value" id="wishlist_indicator_2">0</span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="indicator indicator--trigger--click">
                                        <a href="#" class="indicator__button">
                                            <span class="indicator__area">
                                                <i class="fa fa-shopping-cart"></i> <span class="indicator__value" id="cart_indicator_2">0</span>
                                            </span>
                                        </a>
                                        <div class="indicator__dropdown">
                                            <!-- .dropcart -->
                                            <div class="dropcart dropcart--style--dropdown">
                                                <div class="dropcart__body" id="cart_dropdown">
                                                </div>
                                            </div>
                                            <!-- .dropcart / end -->
                                        </div>
                                    </div>
                                @endauth
                                <div class="indicator indicator--trigger--click">
                                    <a href="{{ route('/') }}" class="indicator__button">
                                        <span class="indicator__area">
                                            <i class="fa fa-user"></i>
                                            <span class="indicator__value" id="transaction_indicator_2">0</span>
                                        </span>
                                    </a>
                                    <div class="indicator__dropdown">
                                        <div class="account-menu">
                                            @guest
                                                <form class="account-menu__form" method="post" action="{{ route('login.process') }}">
                                                    @csrf
                                                    <div class="account-menu__form-title">{{ __('layout.login_caption') }}</div>
                                                    <div class="form-group">
                                                        <label for="header-signin-email" class="sr-only">{{ __('model.email') }}</label>
                                                        <input id="header-signin-email" type="email" name="email" class="form-control form-control-sm" placeholder="Email address" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="header-signin-password" class="sr-only">{{ __('model.password') }}</label>
                                                        <div class="account-menu__form-forgot">
                                                            <input id="header-signin-password" type="password" name="password" class="form-control form-control-sm" placeholder="Password" />
{{--                                                            <a href="#" class="account-menu__form-forgot-link">{{ __('layout.forgot') }}?</a>--}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group account-menu__form-button"><button type="submit" class="btn btn-primary btn-sm">{{ __('layout.login') }}</button></div>
                                                    <div class="account-menu__form-link"><a href="{{ route('register') }}">{{ __('layout.register') }}</a></div>
                                                </form>
                                            @endguest
                                            @auth
                                                <div class="account-menu__divider"></div>
                                                <a href="{{ route('user') }}" class="account-menu__user">
                                                    <div class="account-menu__user-avatar"><img src="{{ Auth::user()->photo_location }}" alt="" /></div>
                                                    <div class="account-menu__user-info">
                                                        <div class="account-menu__user-name">{{ Auth::user()->name }}</div>
                                                        <div class="account-menu__user-email">{{ Auth::user()->email }}</div>
                                                    </div>
                                                </a>
                                                <div class="account-menu__divider"></div>
                                                <ul class="account-menu__links">
                                                    <li><a href="{{ route('user.edit_profile') }}">{{ __('layout.edit_profile') }}</a></li>
                                                    <li>
                                                        <a href="{{ route('user.order_history') }}">
                                                            {{ __('layout.order_history') }}
                                                            <span class="indicator__value bg-dark text-white" id="transaction_indicator_3">0</span>
                                                        </a>
                                                    </li>
                                                    <li><a href="{{ route('user.change_password') }}">{{ __('layout.change_password') }}</a></li>
                                                    @if(count(Auth::user()->store_owner) > 0)
                                                        <li><a href="{{ route('user.store') }}">Toko</a></li>
                                                    @endif
                                                </ul>
                                                <div class="account-menu__divider"></div>
                                                <ul class="account-menu__links">
                                                    <li><a href="{{ route('logout') }}">{{ __('layout.logout') }}</a></li>
                                                </ul>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="site__footer">
        <div class="site-footer">
            <div class="container">
                <div class="site-footer__bottom">
                    <div class="site-footer__copyright">
                        Pidi-pidi by Renandatta
                    </div>
                </div>
            </div>
            <div class="totop">
                <div class="totop__body">
                    <div class="totop__start"></div>
                    <div class="totop__container container"></div>
                    <div class="totop__end">
                        <button type="button" class="totop__button">
                            <i class="fa fa-angle-up"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- site / end --><!-- quickview-modal -->
<div id="quickview-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl"><div class="modal-content"></div></div>
</div>
<!-- quickview-modal / end --><!-- mobilemenu -->
<div class="mobilemenu">
    <div class="mobilemenu__backdrop"></div>
    <div class="mobilemenu__body">
        <div class="mobilemenu__header">
            <div class="mobilemenu__title">{{ __('layout.category') }}</div>
            <button type="button" class="mobilemenu__close">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <div class="mobilemenu__content">
            <ul class="mobile-links mobile-links--level--0" data-collapse data-collapse-opened-class="mobile-links__item--open">
                @foreach($productCategories as $productCategory)
                <li class="mobile-links__item" data-collapse-item>
                    <div class="mobile-links__item-title">
                        <a href="{{ route('category', $productCategory->slug) }}" class="mobile-links__item-link">{{ $productCategory->name }}</a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <!--<button class="pswp__button pswp__button&#45;&#45;share" title="Share"></button>-->
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button> <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut"><div class="pswp__preloader__donut"></div></div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap"><div class="pswp__share-tooltip"></div></div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button> <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
            <div class="pswp__caption"><div class="pswp__caption__center"></div></div>
        </div>
    </div>
</div>
<script>
    function add_commas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }
    function remove_commas(nStr) {
        nStr = nStr.replace(/\./g,'');
        return nStr;
    }
</script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('vendor/nouislider/nouislider.min.js') }}"></script>
<script src="{{ asset('vendor/photoswipe/photoswipe.min.js') }}"></script>
<script src="{{ asset('vendor/photoswipe/photoswipe-ui-default.min.js') }}"></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/number.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/header.js') }}"></script>
<script src="{{ asset('vendor/svg4everybody/svg4everybody.min.js') }}"></script>
<script>
    svg4everybody();
    $('.select2').select2();

    $('#transaction_indicator').hide();
    $('#transaction_indicator_2').hide();
    $('#transaction_indicator_3').hide();
    $('#wishlist_indicator').hide();
    $('#wishlist_indicator_2').hide();
    $('#cart_indicator').hide();
    $('#cart_indicator_2').hide();
</script>
@auth
    <script>
        $.get("{{ route('wishlist.search', ['user_id=' . \Illuminate\Support\Facades\Auth::user()->id]) }}", function (result) {
            if (result.length > 0) {
                $('#wishlist_indicator').show();
                $('#wishlist_indicator_2').show();
            }
            $('#wishlist_indicator').html(result.length);
            $('#wishlist_indicator_2').html(result.length);
        });
        $.get("{{ route('cart.search', ['user_id=' . \Illuminate\Support\Facades\Auth::user()->id]) }}", function (result) {
            $('#cart_dropdown').html(result);
        });
        $.get("{!! route('cart.search', ['count=1', 'user_id=' . \Illuminate\Support\Facades\Auth::user()->id]) !!}", function (result) {
            if (result > 0) {
                $('#cart_indicator').show();
                $('#cart_indicator_2').show();
            }
            $('#cart_indicator').html(result);
            $('#cart_indicator_2').html(result);
        });
        $.post("{{ route('recent_purchases') }}", {_token: '{{ csrf_token() }}'}, function (result) {
            if (result.length > 0) {
                $('#transaction_indicator').show();
                $('#transaction_indicator_2').show();
                $('#transaction_indicator_3').show();
            }
            $('#transaction_indicator').html(result.length);
            $('#transaction_indicator_2').html(result.length);
            $('#transaction_indicator_3').html(result.length);
        });
    </script>
@endauth
@stack('scripts')
</body>
</html>
