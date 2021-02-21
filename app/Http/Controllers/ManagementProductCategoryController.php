<?php

namespace App\Http\Controllers;

use App\Repositories\ProductCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementProductCategoryController extends Controller
{
    private $productCategoryRepository;
    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->middleware('auth');
        $this->middleware('management');
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function index()
    {
        Session::put('menu_active', 'product_category');
        return view('management.product_category.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $productCategorys = $this->productCategoryRepository->search($parameters, null, 10);
        return $request->has('ajax') ? $productCategorys : view('management.product_category._table', compact('productCategorys'));
    }

    public function info(Request $request)
    {
        $parent_code = $request->input('parent_code') ?? '#';
        $productCategory = $request->has('id') ? $this->productCategoryRepository->find($request->get('id')) : [];
        $parent_code = !empty($productCategory) ? $productCategory->parent_code : $parent_code;
        $code = !empty($productCategory) ? $productCategory->code : $this->productCategoryRepository->code($parent_code);
        return view('management.product_category.info', compact('productCategory', 'parent_code', 'code'));
    }

    public function save(Request $request)
    {
        if ($request->has('id')) {
            $productCategory = $this->productCategoryRepository->update($request->input('id'), $request);
        } else {
            $productCategory = $this->productCategoryRepository->save($request);
        }
        return redirect()->route('management.product_category')
            ->with('success', 'Produk Kategori Berhasil Disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $this->productCategoryRepository->delete($request->input('id'));
        return redirect()->route('management.product_category')
            ->with('success', 'Produk Kategori Berhasil Dihapus');
    }
}
