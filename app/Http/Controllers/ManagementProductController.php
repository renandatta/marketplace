<?php

namespace App\Http\Controllers;

use App\Repositories\CourierRepository;
use App\Repositories\ProductRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ManagementProductController extends Controller
{
    private $productRepository;
    private $storeRepository;
    public function __construct(ProductRepository $productRepository,
                                StoreRepository $storeRepository)
    {
        $this->middleware('auth');
        $this->productRepository = $productRepository;
        $this->storeRepository = $storeRepository;
    }

    public function index(Request $request)
    {
        if (Auth::user()->user_level != 'Administrator') {
            if (count(Auth::user()->store_owner) == 0) return abort(404);
            if (!$request->has('store_id'))
                return redirect()->route('management.store.product', 'store_id=' . Auth::user()->store_owner[0]->store_id);
        }

        Session::put('menu_active', 'product');
        $store_id = $request->get('store_id');
        return view('management.product.index', compact('store_id'));
    }

    public function search(Request $request)
    {
        $store_id = $request->input('store_id');
        $parameters = [];
        if ($request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        if ($request->input('store_id') != '')
            array_push($parameters, [
                'column' => 'store_id', 'value' => $request->input('store_id')
            ]);
        $products = $this->productRepository->search($parameters, null, 10);
        return $request->has('ajax') ? $products : view('management.product._table', compact('products', 'store_id'));
    }

    public function info(Request $request)
    {
        $store_id = $request->get('store_id');
        $categories = $this->productRepository->get_all_child_category();
        $product = $request->has('id') ? $this->productRepository->find($request->get('id')) : [];
        $stores = $store_id == null ? $this->storeRepository->search() : $this->storeRepository->find($store_id);
        $featuredProducts = $this->productRepository->search_featured();
        return view('management.product.info', compact(
            'product', 'store_id', 'categories', 'stores', 'featuredProducts'
        ));
    }

    public function save(Request $request)
    {
        $request->merge(['price' => unformat_number($request->input('price'))]);
        if ($request->has('id')) {
            $product = $this->productRepository->update($request->input('id'), $request);
        } else {
            $product = $this->productRepository->save($request);
        }
        if ($request->has('ajax')) return $product;
        return redirect()->route('management.store.product', 'store_id=' . $product->store_id)
            ->with('success', 'Produk Berhasil Disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $product = $this->productRepository->delete($request->input('id'));
        if ($request->has('ajax')) return $product;
        return redirect()->route('management.store.product', 'store_id=' . $product->store_id)
            ->with('success', 'Produk Berhasil Dihapus');
    }
}
