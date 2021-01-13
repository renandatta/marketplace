@section('title')
    @php($title = ucwords(str_replace("_", " ", Session::get('user_menu_active'))))
    {{ __('layout.' . Session::get('user_menu_active')) }}
@endsection

<div class="page-header">
    <div class="page-header__container container">
        <div class="page-header__breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('/') }}">Home</a>
                        <i class="fa fa-angle-right breadcrumb-arrow"></i>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('user') }}">User</a>
                        <i class="fa fa-angle-right breadcrumb-arrow"></i>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('layout.' . Session::get('user_menu_active')) }}</li>
                </ol>
            </nav>
        </div>
        <div class="page-header__title"><h1>{{ __('layout.' . Session::get('user_menu_active')) }}</h1></div>
    </div>
</div>
