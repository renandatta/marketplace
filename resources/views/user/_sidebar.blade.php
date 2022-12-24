<div class="account-nav flex-grow-1">
    <h4 class="account-nav__title">{{ __('layout.user_page') }}</h4>
    <ul>
        <li class="account-nav__item @if(Session::get('user_menu_active') == 'dashboard') account-nav__item--active @endif">
            <a href="{{ route('user.dashboard') }}">{{ __('layout.dashboard') }}</a>
        </li>
        <li class="account-nav__item @if(Session::get('user_menu_active') == 'edit_profile') account-nav__item--active @endif">
            <a href="{{ route('user.edit_profile') }}">{{ __('layout.edit_profile') }}</a>
        </li>
        <li class="account-nav__item @if(Session::get('user_menu_active') == 'change_password') account-nav__item--active @endif">
            <a href="{{ route('user.change_password') }}">{{ __('layout.change_password') }}</a>
        </li>
        <li class="account-nav__item @if(Session::get('user_menu_active') == 'order_history') account-nav__item--active @endif">
            <a href="{{ route('user.order_history') }}">{{ __('layout.order_history') }}</a>
        </li>
        <li class="account-nav__item @if(Session::get('user_menu_active') == 'address') account-nav__item--active @endif">
            <a href="{{ route('user.address') }}">{{ __('layout.address') }}</a>
        </li>
        @if(count(Auth::user()->store_owner) > 0)
            <li class="account-nav__item @if(Session::get('user_menu_active') == 'store') account-nav__item--active @endif">
                <a href="{{ route('user.store') }}">Toko</a>
            </li>
            <li class="account-nav__item @if(Session::get('user_menu_active') == 'store_product') account-nav__item--active @endif">
                <a href="{{ route('management.store.product', 'store_id=' . Auth::user()->store_owner[0]->store_id) }}">Produk Toko</a>
            </li>
        @endif
        <li class="account-nav__item">
            <a href="{{ route('logout') }}">Logout</a>
        </li>
    </ul>
</div>
