<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementProductImageController extends Controller
{
    private $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->middleware('auth');
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        if (!$request->has('product_id')) return redirect()->back();
        Session::put('menu_active', 'product');
        $productId = $request->get('product_id');
        return view('management.product.image.index', compact('productId'));
    }

    public function search(Request $request)
    {
        $productId = $request->input('product_id');
        $parameters = [];
        if ($request->input('product_id') != '')
            array_push($parameters, [
                'column' => 'product_id', 'value' => $request->input('product_id')
            ]);
        $images = $this->productRepository->search_image($parameters, null);
        return $request->has('ajax') ? $images : view('management.product.image._table', compact('images', 'productId'));
    }

    public function save(Request $request)
    {
        if (!$request->has('product_id')) return abort(404);
        $image = $this->productRepository->save_image($request);
        return redirect()->route('management.store.product.image', 'product_id=' . $image->product_id)
            ->with('success', 'Foto Produk Berhasil Disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $image = $this->productRepository->delete_image($request->input('id'));
        if ($request->has('ajax')) return $image;
        return redirect()->route('management.store.product.image', 'product_id=' . $image->product_id)
            ->with('success', 'Foto Produk Berhasil Dihapus');
    }
}
