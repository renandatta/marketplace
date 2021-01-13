@extends('layouts.management')

@section('title')
    Informasi Produk
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
    <h4>{{ empty($product) ? 'Tambah' : 'Ubah' }} Produk</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('management.store.product.save') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if(!empty($product))
                    <input type="hidden" name="id" value="{{ $product->id }}">
                @endif
                <div class="row">
                    <div class="col-md-8">
                        @if($store_id == null)
                            <div class="form-group">
                                <label for="store_id">Toko</label>
                                <select name="store_id" id="store_id" class="form-control select2">
                                    <option value="">-</option>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}"  @if(!empty($product) && $product->store_id == $store->id) selected @endif>{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="form-group">
                                <label for="store">Toko</label>
                                <input type="text" class="form-control" id="store" name="store" value="{{ !empty($product) ? $product->store->name : $stores->name }}" readonly>
                            </div>
                            <input type="hidden" name="store_id" value="{{ !empty($product) ? $product->store_id : $store_id }}">
                        @endif
                        <div class="form-group">
                            <label for="product_category_id">Kategori Produk</label>
                            <select name="product_category_id" id="product_category_id" class="form-control select2">
                                <option value="">-</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"  @if(!empty($product) && $product->product_category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', !empty($product) ? $product->name : '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="text" class="form-control autonumeric" id="price" name="price" value="{{ old('price', !empty($product) ? $product->price : '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="weight">Berat (gram)</label>
                            <input type="text" class="form-control" id="weight" name="weight" value="{{ old('weight', !empty($product) ? $product->weight : '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stok</label>
                            <input type="text" class="form-control" id="stock" name="stock" value="{{ old('stock', !empty($product) ? $product->stock : '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="stock_min">Stok Minimal</label>
                            <input type="text" class="form-control" id="stock_min" name="stock_min" value="{{ old('stock_min', !empty($product) ? $product->stock_min : '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Keterangan</label>
                            <textarea name="description" id="description" rows="15" class="form-control">{{ old('description', !empty($product) ? $product->description : '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="image">Foto Produk</label>
                            <input type="file" class="dropify" name="image" id="image" @if(!empty($product) && count($product->images)) data-default-file="{{ $product->images[0]->location }}" @endif>
                        </div>
                        @if(!empty($product))
                            <div class="text-right">
                                <a class="btn btn-sm btn-success" href="{{ route('management.store.product.image', 'product_id=' . $product->id) }}"><i class="fa fa-images"></i> Tambahkan Foto Lainnya</a>
                            </div>
                            <hr />
                            <h5>Kategori Produk Unggulan</h5>
                            @php($listFeaturedId = [])
                            @foreach($product->featured_list as $item)
                                @php(array_push($listFeaturedId, $item->featured_product_id))
                            @endforeach

                            @foreach($featuredProducts as $featured)
                                <p class="mb-0">
                                    @if(in_array($featured->id, $listFeaturedId))
                                        <a class="text-black" href="{{ route('management.featured.detail', 'featured_id=' . $featured->id) }}">
                                            <i class="fa fa-check"></i> {{ $featured->name }}
                                        </a>
                                    @else
                                        <a class="text-black" href="javascript:void(0);" onclick="document.getElementById('form_featured_{{ $featured->id }}').submit()">
                                            <i class="fa fa-plus-circle"></i> {{ $featured->name }}
                                        </a>
                                    @endif
                                </p>
                            @endforeach
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('management.store.product') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
        @if(!empty($product))
            <div class="card-footer text-right">
                <form action="{{ route('management.store.product.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        @endif
    </div>

    @if(!empty($product))
        @foreach($featuredProducts as $featured)
            <form action="{{ route('management.featured.save_detail') }}" method="post" id="form_featured_{{ $featured->id }}" style="display: none;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="featured_product_id" value="{{ $featured->id }}">
            </form>
        @endforeach
    @endif
@endsection


@push('scripts')
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('.dropify').dropify();

        let selectedCity = '{{ !empty($store) ? $store->city : '' }}';
        $('#province').change(function () {
            let id = $('#province').find('option:selected').attr('data-id');
            $('#province_id').val(id);
            let city = $('#city');
            city.html('<option value="">-</option>');
            if (id !== '') {
                city.html('<option value="">Loading ...</option>');
                $.post("{{ route('user.city.search') }}", {
                    _token: '{{ csrf_token() }}',
                    province_id: id
                }, function (result) {
                    city.html('<option value="">-</option>');
                    $.each(result, function (i, value) {
                        let selected = (selectedCity == value.city_name) ? 'selected' : '';
                        city.append('<option value="'+ value.city_name +'" data-id="'+ value.city_id +'" '+ selected +'>'+ value.city_name +'</option>');
                    });
                    $('#city').trigger('change');
                });
            }
        });
        $('#city').change(function () {
            let id = $('#city').find('option:selected').attr('data-id');
            $('#city_id').val(id);
        });
        if (selectedCity !== '') $('#province').trigger('change');
    </script>
@endpush
