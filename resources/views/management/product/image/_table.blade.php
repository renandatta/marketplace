<div class="row">
    <div class="col-md-2">
        <div class="card mb-3">
            <form action="{{ route('management.store.product.image.save') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $productId }}">
                <div class="card-body p-1 text-center">
                    <input type="file" class="dropify" name="image" data-height="130">
                </div>
                <div class="card-footer p-1">
                    <button type="submit" class="btn btn-sm btn-block btn-danger">Simpan Foto</button>
                </div>
            </form>
        </div>
    </div>
    @foreach($images as $image)
        <div class="col-md-2">
            <div class="card mb-3">
                <div class="card-body p-1">
                    <img src="{{ $image->image_location }}" alt="" class="img-fluid">
                </div>
                <div class="card-footer p-1">
                    <form action="{{ route('management.store.product.image.delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $image->id }}">
                        <button type="submit" class="btn btn-sm btn-block btn-danger">Hapus Foto</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
