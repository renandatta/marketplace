@extends('layouts.management')

@section('title')
    Foto Produk
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.min.css') }}">
    <style>
        .dropify-wrapper .dropify-message p{
            font-size: 12pt;
        }
    </style>
@endpush

@section('content')
    <h4>Foto Produk</h4>
    <div class="card">
        <div class="card-body">
            <div id="table_data"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('.dropify').dropify();
        function searchPage(page = 1) {
            let searchSubmit = $('#search_submit');
            searchSubmit.html('Loading ...');
            $.post("{{ route('management.store.product.image.search') }}", {
                _token: '{{ csrf_token() }}',
                product_id: '{{ $productId }}',
            }, function (result) {
                $('#table_data').html(result);
                $('.dropify').dropify();
                searchSubmit.html('Proses Cari');
            }).fail(function (xhr) {
                console.log(xhr.responseText);
            });
        }
        searchPage();
    </script>
@endpush
