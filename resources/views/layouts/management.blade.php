<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="format-detection" content="telephone=no" />
    <title>@yield('title'){{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/select2/css/select2.min.css') }}" />
    <!-- font - fontawesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}" />
    <!-- font - stroyka -->
    <link rel="stylesheet" href="{{ asset('fonts/stroyka/stroyka.css') }}" />
    <style>
        body {
            font-family: 'Abel', sans-serif!important;
            background-color: #eaeaea;
        }
        .bg-dark {
            background-color: #000!important;
        }
        .text-black {
            color: #212529;
        }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('management') }}">
            <img src="{{ asset('images/logo.jpg') }}" height="30" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mr-auto">
                @if(Auth::user()->user_level == 'Administrator')
                    <li class="nav-item @if(Session::get('menu_active') == 'home') active @endif">
                        <a class="nav-link" href="{{ route('management') }}">Home</a>
                    </li>
                    <li class="nav-item @if(Session::get('menu_active') == 'user') active @endif">
                        <a class="nav-link" href="{{ route('management.user') }}">User</a>
                    </li>
                    <li class="nav-item @if(Session::get('menu_active') == 'category') active @endif">
                        <a class="nav-link" href="{{ route('management.product_category') }}">Produk Kategori</a>
                    </li>
                    <li class="nav-item @if(Session::get('menu_active') == 'payment_type') active @endif">
                        <a class="nav-link" href="{{ route('management.payment_type') }}">Metode Pembayaran</a>
                    </li>
                    <li class="nav-item @if(Session::get('menu_active') == 'courier') active @endif">
                        <a class="nav-link" href="{{ route('management.courier') }}">Kurir Pengiriman</a>
                    </li>
                    <li class="nav-item @if(Session::get('menu_active') == 'store') active @endif">
                        <a class="nav-link" href="{{ route('management.store') }}">Toko</a>
                    </li>
                    <li class="nav-item @if(Session::get('menu_active') == 'product') active @endif">
                        <a class="nav-link" href="{{ route('management.store.product') }}">Produk</a>
                    </li>
                    <li class="nav-item @if(Session::get('menu_active') == 'slider') active @endif">
                        <a class="nav-link" href="{{ route('management.slider') }}">Slider</a>
                    </li>
                    <li class="nav-item @if(Session::get('menu_active') == 'featured_product') active @endif">
                        <a class="nav-link" href="{{ route('management.featured') }}">Produk Unggulan</a>
                    </li>
                    <li class="nav-item @if(Session::get('menu_active') == 'transaction') active @endif">
                        <a class="nav-link" href="{{ route('management.transaction') }}">Transaksi</a>
                    </li>
                @else
                    <li class="nav-item @if(Session::get('menu_active') == 'home') active @endif">
                        <a class="nav-link" href="{{ route('/') }}">Halama Utama</a>
                    </li>
                    <li class="nav-item @if(Session::get('menu_active') == 'product') active @endif">
                        <a class="nav-link" href="{{ route('management.store.product', 'store_id=' . Auth::user()->store_owner[0]->store_id) }}">Produk</a>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container pt-4">
    @yield('content')
</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('lib/autoNumeric.js') }}"></script>
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
<script>
    $('.select2').select2();
    $('.autonumeric').attr('data-a-sep','.');
    $('.autonumeric').attr('data-a-dec',',');
    $('.autonumeric').autoNumeric({mDec: '0',vMax:'9999999999999999999999999', vMin: '-99999999999999999'});
    $('.autonumeric-decimal').attr('data-a-sep','.');
    $('.autonumeric-decimal').attr('data-a-dec',',');
    $('.autonumeric-decimal').autoNumeric({mDec: '2',vMax:'999'});
</script>
@stack('scripts')
</body>
</html>
