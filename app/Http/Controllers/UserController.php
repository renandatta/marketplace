<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\SaveProfileRequest;
use App\Http\Requests\UserAddressRequest;
use App\Repositories\CourierRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\ShipmentRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $productRepository;
    private $userRepository;
    private $courierRepository;
    private $purchaseRepository;
    private $shipmentRepository;
    public function __construct(ProductRepository $productRepository,
                                UserRepository $userRepository,
                                CourierRepository $courierRepository,
                                PurchaseRepository $purchaseRepository, ShipmentRepository $shipmentRepository)
    {
        $this->middleware('auth');
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->courierRepository = $courierRepository;
        $this->purchaseRepository = $purchaseRepository;
        $this->shipmentRepository = $shipmentRepository;

        view()->share('productCategories', $this->productRepository->getAllParentCategory());
    }

    public function dashboard()
    {
        Session::put('user_menu_active', 'dashboard');
        $recentPurchases = $this->recent_purchases();
        return view('user.dashboard', compact('recentPurchases'));
    }

    public function recent_purchases()
    {
        $parameters = array();
        array_push($parameters, ['column' => 'user_id', 'value' => Auth::user()->id]);
        array_push($parameters, [
            'column' => 'status',
            'value' => ['waiting payment', 'waiting payment receipt', 'waiting payment confirmation'],
            'custom' => 'in_array'
        ]);
        return $this->purchaseRepository->get_all($parameters);
    }

    public function edit_profile()
    {
        Session::put('user_menu_active', 'edit_profile');
        return view('user.edit_profile');
    }

    public function change_password()
    {
        Session::put('user_menu_active', 'change_password');
        return view('user.change_password');
    }

    public function save_profile(SaveProfileRequest $request)
    {
        if (!Auth::check()) return abort(403);
        $this->userRepository->updateProfile(
            Auth::user()->id,
            $request->input('email'),
            $request->input('name'),
            $request->hasFile('photo') ? $request->file('photo') : null
        );
        return redirect()->route('user')
            ->with('success', 'User Updated');
    }

    public function save_password(ChangePasswordRequest $request)
    {
        if (!Auth::check()) return abort(403);
        $this->userRepository->updatePassword(Auth::user()->id, $request->input('password'));
        return redirect()->route('user')
            ->with('success', 'Password Updated');
    }

    public function address()
    {
        Session::put('user_menu_active', 'address');
        $addresses = $this->userRepository->getUserAddress(Auth::user()->id);
        return view('user.address', compact('addresses'));
    }

    public function address_new()
    {
        Session::put('user_menu_active', 'address');
        $id = 'new';
        $provinces = $this->courierRepository->get_province_all();
        return view('user.address_new', compact('id', 'provinces'));
    }

    public function address_edit(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        Session::put('user_menu_active', 'address');
        $id = $request->get('id');
        $address = $this->userRepository->findAddress($id);
        if ($address == false) return abort(404);
        $provinces = $this->courierRepository->get_province_all();
        return view('user.address_new', compact('id', 'address', 'provinces'));
    }

    public function address_save(UserAddressRequest $request)
    {
        if (!Auth::check()) return abort(403);
        if (!$request->has('id')) return abort(404);
        $request->merge(['user_id' => Auth::user()->id]);
        $address = $this->userRepository->saveAddress($request);
        if ($address == false) return abort(404);
        return redirect()->route('user.address')
            ->with('success', 'User Address Saved');
    }

    public function address_delete(Request $request)
    {
        if (!Auth::check()) return abort(403);
        if (!$request->has('id')) return abort(404);
        $this->userRepository->deleteAddreess($request->input('id'));
        return redirect()->route('user.address')
            ->with('success', 'User Address Deleted');
    }

    public function address_default(Request $request)
    {
        if (!Auth::check()) return abort(403);
        if (!$request->has('id')) return abort(404);
        $this->userRepository->defaultAddress($request->input('id'));
        return redirect()->route('user.address')
            ->with('success', 'User Address Updated');
    }

    public function city_search(Request $request)
    {
        if (!Auth::check()) return abort(403);
        if (!$request->has('province_id')) return abort(404);
        return $this->courierRepository->get_city_by_province($request->input('province_id'));
    }

    public function order_history()
    {
        Session::put('user_menu_active', 'order_history');
        $purchaseHistories = $this->purchaseRepository->get_all(array(['column' => 'user_id', 'value' => Auth::user()->id]));
        return view('user.order_history', compact('purchaseHistories'));
    }

    public function store()
    {
        Session::put('user_menu_active', 'store');
        $store = $this->userRepository->user_store();

        $parameters = array();
        array_push($parameters, ['column' => 'purchases.status', 'value' => 'payment verified']);
        array_push($parameters, ['column' => 'products.store_id', 'value' => $store->id]);
        $transactions = $this->purchaseRepository->search_detail_with_group($parameters);
        foreach ($transactions as $key => $value) {
            $purchase = $this->purchaseRepository->find($value->purchase_id);
            $transactions[$key]->check_shipment = $this->shipmentRepository->check_store_shipment($purchase, $store);
        }
        return view('user.store', compact('store', 'transactions'));
    }

    public function transaction_detail(Request $request)
    {
        if (!$request->has('no_order')) return abort(404);
        $purchase = $this->purchaseRepository->find($request->get('no_order'), 'no_purchase');

        $store = $this->userRepository->user_store();
        $parameters = array();
        array_push($parameters, ['column' => 'purchase_id', 'value' => $purchase->id]);
        array_push($parameters, ['column' => 'products.store_id', 'value' => $store->id]);
        $transactions = $this->purchaseRepository->search($parameters);
        $shipment = $this->shipmentRepository->get_store_shipment($purchase, $store);
        return view('user.store.transaction_detail', compact('transactions', 'purchase', 'shipment'));
    }

    public function shipping_save(Request $request)
    {
        if (!$request->has('purchase_id')) return abort(404);
        if (!$request->has('courier_service_id')) return abort(404);

        $store = $this->userRepository->user_store();
        $request->merge(['store_id' => $store->id]);
        $this->shipmentRepository->save($request);
        return redirect()->route('user.store');
    }
}
