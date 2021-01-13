<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementFeaturedDetailController extends Controller
{
    private $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->middleware('auth');
        $this->middleware('management');
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        if (!$request->has('featured_id')) return abort(404);
        $featuredId = $request->get('featured_id');
        Session::put('menu_active', 'featured');
        return view('management.featured.detail.index', compact('featuredId'));
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->input('featured_id') != '')
            array_push($parameters, [
                'column' => 'featured_product_id', 'value' => $request->input('featured_id')
            ]);
        if ($request->input('name') != '')
            array_push($parameters, [
                'column' => 'products.name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $featured_details = $this->productRepository->search_featured_detail($parameters, null, 10);
        return $request->has('ajax') ?
            $featured_details : view('management.featured.detail._table', compact('featured_details'));
    }

    public function info(Request $request)
    {
        $featured_detail = $request->has('id') ? $this->productRepository->find_featured_detail($request->get('id')) : [];
        return view('management.featured.detail.info', compact('featured_detail'));
    }

    public function save(Request $request)
    {
        if ($request->has('id')) {
            $featured_detail = $this->productRepository->update_featured_detail($request->input('id'), $request);
        } else {
            $featured_detail = $this->productRepository->save_featured_detail($request);
        }
        if ($request->has('ajax')) return $featured_detail;
        return redirect()->route('management.featured.detail')
            ->with('success', 'Featured Berhasil Disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $featured_detail = $this->productRepository->delete_featured_detail($request->input('id'));
        if ($request->has('ajax')) return $featured_detail;
        return redirect()->route('management.featured.detail', 'featured_id=' . $featured_detail->featured_product_id)
            ->with('success', 'Featured Berhasil Dihapus');
    }
}
