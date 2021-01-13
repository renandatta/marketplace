<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementFeaturedController extends Controller
{
    private $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->middleware('auth');
        $this->middleware('management');
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        Session::put('menu_active', 'featured');
        return view('management.featured.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $featureds = $this->productRepository->search_featured($parameters, null, 10);
        return $request->has('ajax') ? $featureds : view('management.featured._table', compact('featureds'));
    }

    public function info(Request $request)
    {
        $featured = $request->has('id') ? $this->productRepository->find_featured($request->get('id')) : [];
        return view('management.featured.info', compact('featured'));
    }

    public function save(Request $request)
    {
        if ($request->has('id')) {
            $featured = $this->productRepository->update_featured($request->input('id'), $request);
        } else {
            $featured = $this->productRepository->save_featured($request);
        }
        if ($request->has('ajax')) return $featured;
        return redirect()->route('management.featured')
            ->with('success', 'Featured Berhasil Disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $featured = $this->productRepository->delete_featured($request->input('id'));
        if ($request->has('ajax')) return $featured;
        return redirect()->route('management.featured')
            ->with('success', 'Featured Berhasil Dihapus');
    }

    public function save_detail(Request $request)
    {
        $detail = $this->productRepository->save_featured_detail($request);
        if ($request->has('ajax')) return $detail;
        return redirect()->route('management.store.product.info', 'id=' . $detail->product_id);
    }
}
