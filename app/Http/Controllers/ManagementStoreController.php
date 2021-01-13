<?php

namespace App\Http\Controllers;

use App\Repositories\CourierRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementStoreController extends Controller
{
    private $storeRepository;
    private $courierRepository;
    public function __construct(StoreRepository $storeRepository,
                                CourierRepository $courierRepository)
    {
        $this->middleware('auth');
        $this->middleware('management');
        $this->storeRepository = $storeRepository;
        $this->courierRepository = $courierRepository;
    }

    public function index()
    {
        Session::put('menu_active', 'store');
        return view('management.store.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $stores = $this->storeRepository->search($parameters, null, 10);
        return $request->has('ajax') ? $stores : view('management.store._table', compact('stores'));
    }

    public function info(Request $request)
    {
        $provinces = $this->courierRepository->get_province_all();
        $storeLevels = $this->storeRepository->getAllLevel();
        $store = $request->has('id') ? $this->storeRepository->find($request->get('id')) : [];
        return view('management.store.info', compact('store', 'provinces', 'storeLevels'));
    }

    public function save(Request $request)
    {
        if ($request->has('id')) {
            $store = $this->storeRepository->update($request->input('id'), $request);
        } else {
            $store = $this->storeRepository->save($request);
        }
        return redirect()->route('management.store')
            ->with('success', 'Toko Berhasil Disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $this->storeRepository->delete($request->input('id'));
        return redirect()->route('management.store')
            ->with('success', 'Toko Berhasil Dihapus');
    }
}
