<?php

namespace App\Http\Controllers;

use App\Repositories\PaymentTypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementPaymentTypeController extends Controller
{
    private $paymentTypeRepository;
    public function __construct(PaymentTypeRepository $paymentTypeRepository)
    {
        $this->middleware('auth');
        $this->middleware('management');
        $this->paymentTypeRepository = $paymentTypeRepository;
    }

    public function index()
    {
        Session::put('menu_active', 'payment_type');
        return view('management.payment_type.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $paymentTypes = $this->paymentTypeRepository->search($parameters, null, 10);
        return $request->has('ajax') ? $paymentTypes : view('management.payment_type._table', compact('paymentTypes'));
    }

    public function info(Request $request)
    {
        $paymentType = $request->has('id') ? $this->paymentTypeRepository->find($request->get('id')) : [];
        return view('management.payment_type.info', compact('paymentType'));
    }

    public function save(Request $request)
    {
        $request->merge(['description' => trim($request->input('description'))]);
        $request->merge(['instruction' => trim($request->input('instruction'))]);
        if ($request->has('id')) {
            $paymentType = $this->paymentTypeRepository->update($request->input('id'), $request);
        } else {
            $paymentType = $this->paymentTypeRepository->save($request);
        }
        return redirect()->route('management.payment_type')
            ->with('success', 'Metode Pembayaran Berhasil Disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $this->paymentTypeRepository->delete($request->input('id'));
        return redirect()->route('management.payment_type')
            ->with('success', 'Metode Pembayaran Berhasil Dihapus');
    }
}
