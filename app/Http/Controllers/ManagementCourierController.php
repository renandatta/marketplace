<?php

namespace App\Http\Controllers;

use App\Repositories\CourierRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementCourierController extends Controller
{
    private $courierRepository;
    public function __construct(CourierRepository $courierRepository)
    {
        $this->middleware('auth');
        $this->middleware('management');
        $this->courierRepository = $courierRepository;
    }

    public function index()
    {
        Session::put('menu_active', 'courier');
        return view('management.courier.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $couriers = $this->courierRepository->search($parameters, null, 10);
        if ($request->has('ajax')) return $couriers;
        return view('management.courier._table', compact('couriers'));
    }

    public function info(Request $request)
    {
        $courier = $request->has('id') ? $this->courierRepository->find($request->get('id')) : [];
        return view('management.courier.info', compact('courier'));
    }

    public function save(Request $request)
    {
        if ($request->has('id')) {
            $courier = $this->courierRepository->update($request->input('id'), $request);
        } else {
            $courier = $this->courierRepository->save($request);
        }
        if ($request->has('ajax')) return $courier;
        return redirect()->route('management.courier')
            ->with('success', 'Kurir Pengiriman Berhasil Disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $courier = $this->courierRepository->delete($request->input('id'));
        if ($request->has('ajax')) return $courier;
        return redirect()->route('management.courier')
            ->with('success', 'Kurir Pengiriman Berhasil Dihapus');
    }
}
