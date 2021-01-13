<?php

namespace App\Http\Controllers;

use App\Repositories\PurchaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementTransactionController extends Controller
{
    private $purchaseRepository;
    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->middleware('auth');
        $this->middleware('management');
        $this->purchaseRepository = $purchaseRepository;
    }

    public function index()
    {
        Session::put('menu_active', 'transaction');
        return view('management.transaction.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $transactions = $this->purchaseRepository->search($parameters, null, 10);
        return $request->has('ajax') ? $transactions : view('management.transaction._table', compact('transactions'));
    }

    public function detail(Request $request)
    {
        if (!$request->has('no_order')) return abort(404);
        $purchase = $this->purchaseRepository->find($request->get('no_order'), 'no_purchase');
        return view('management.transaction.info', compact('purchase'));
    }

    public function payment_verify(Request $request)
    {
        if (!$request->has('purchase_id')) return abort(404);
        $purchase = $this->purchaseRepository->find($request->input('purchase_id'));
        $this->purchaseRepository->verify_purchase($purchase->id);
        return redirect()->route('management.transaction.detail', 'no_order=' . $purchase->no_purchase);
    }

    public function payment_reject(Request $request)
    {
        if (!$request->has('purchase_id')) return abort(404);
        $purchase = $this->purchaseRepository->find($request->input('purchase_id'));
        $this->purchaseRepository->reject_purchase($purchase->id);
        return redirect()->route('management.transaction.detail', 'no_order=' . $purchase->no_purchase);
    }
}
