@extends('layouts.management')

@section('title')
    Produk
@endsection

@section('content')
    <h4>Produk</h4>
    <div class="card">
        <div class="card-body">
            <div class="row mb-0">
                <div class="col-md-10">
                    <form action="{{ route('management.store.product.search') }}" method="post" id="form_search">
                        @csrf

                        <div class="form-group mb-0">
                            <label for="name">Pencarian</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="search_name" name="name" placeholder="...">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit" id="search_submit">Proses Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <label>&nbsp;</label>
                        @php($parameters = [])
                        @if($store_id != null)
                            @php(array_push($parameters, 'store_id=' . $store_id))
                        @endif
                        <a href="{{ route('management.store.product.info', $parameters) }}" class="btn btn-primary btn-block">Tambah</a>
                    </div>
                </div>
            </div>
            <hr>
            <div id="table_data"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let selectedPage = 1;
        $('#form_search').submit(function (e) {
            e.preventDefault();
            let searchSubmit = $('#search_submit');
            searchSubmit.html('Loading ...');
            $.post("{{ route('management.store.product.search') }}?page=" + selectedPage, {
                _token: '{{ csrf_token() }}',
                name: $('#search_name').val(),
                @if($store_id != null)
                    store_id: '{{ $store_id }}',
                @endif
            }, function (result) {
                $('#table_data').html(result);
                searchSubmit.html('Proses Cari');
            }).fail(function (xhr) {
                console.log(xhr.responseText);
            });
        });
        function searchPage(page = 1) {
            if (page === '-1') selectedPage--;
            else if (page === '+1') selectedPage++;
            else selectedPage = page;
            $('#form_search').trigger('submit');
        }
        searchPage();
    </script>
@endpush
