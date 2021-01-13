<?php

namespace App\Http\Controllers;

use App\Repositories\CourierRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementCourierServiceController extends Controller
{
    private $courierRepository;
    public function __construct(CourierRepository $courierRepository)
    {
        $this->middleware('auth');
        $this->middleware('management');
        $this->courierRepository = $courierRepository;
    }

    public function index(Request $request)
    {
        $courierId = $request->get('courier_id');
        Session::put('menu_active', 'courier');
        return view('management.courier.service.index', compact('courierId'));
    }

    public function search(Request $request)
    {
        $courierId = $request->input('courier_id');
        $parameters = [];
        array_push($parameters,
            ['column' => 'courier_id', 'value' => $request->input('courier_id')]
        );
        if ($request->input('name') != '')
            array_push($parameters,
                ['column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like']
            );
        $courierServices = $this->courierRepository->search_service($parameters, null, 10);
        if($request->has('ajax')) return $courierServices;
        return view('management.courier.service._table', compact('courierServices', 'courierId'));
    }

    public function info(Request $request)
    {
        $courierId = $request->get('courier_id');
        $courier = $request->has('id') ? $this->courierRepository->find_service($request->get('id')) : [];
        return view('management.courier.service.info', compact('courier', 'courierId'));
    }

    public function save(Request $request)
    {
        if ($request->has('id')) {
            $courierService = $this->courierRepository->update_service($request->input('id'), $request);
        } else {
            $courierService = $this->courierRepository->save_service($request);
        }
        if ($request->has('ajax')) return $courierService;
        return redirect()->route('management.courier.service', 'courier_id=' . $request->input('courier_id'))
            ->with('success', 'Layanan Kurir Pengiriman Berhasil Disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $courierService = $this->courierRepository->find_service($request->input('id'));
        $this->courierRepository->delete_service($request->input('id'));
        if ($request->has('ajax')) return $courierService;
        return redirect()->route('management.courier.service', 'courier_id=' . $courierService->courier_id)
            ->with('success', 'Layanan Kurir Pengiriman Berhasil Dihapus');
    }
}
