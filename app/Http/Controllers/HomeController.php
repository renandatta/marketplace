<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartDeleteRequest;
use App\Http\Requests\CartSaveRequest;
use App\Http\Requests\CartSearchRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Http\Requests\WishlistDeleteRequest;
use App\Http\Requests\WishlistSaveRequest;
use App\Repositories\CartRepository;
use App\Repositories\CourierRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SliderRepository;
use App\Repositories\StoreRepository;
use App\Repositories\WishlistRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $sliderRepository;
    private $productRepository;
    private $cartRepository;
    private $wishlistRepository;
    private $courierRepository;
    private $storeRepository;
    private $purchaseRepository;
    public function __construct(SliderRepository $sliderRepository,
                                ProductRepository $productRepository,
                                CartRepository $cartRepository,
                                WishlistRepository $wishlistRepository,
                                CourierRepository $courierRepository,
                                StoreRepository $storeRepository,
                                PurchaseRepository $purchaseRepository)
    {
        $this->sliderRepository = $sliderRepository;
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        $this->wishlistRepository = $wishlistRepository;
        $this->courierRepository = $courierRepository;
        $this->storeRepository = $storeRepository;
        $this->purchaseRepository = $purchaseRepository;

        view()->share('productCategories', $this->productRepository->getAllParentCategory());
    }

    public function index()
    {
        $homeCategoryOpen = true;

        $sliders = $this->sliderRepository->getAll();
        $bestSellers = $this->productRepository->getFeaturedProductByName('Best Seller')->details;
        $specials = $this->productRepository->getFeaturedProductByName('This Month Special')->details;
        $forusers = $this->productRepository->getFeaturedProductByName('For You')->details;
        $favorites = $this->productRepository->getFeaturedProductByName('Favorite')->details;
        $promotions = $this->productRepository->getFeaturedProductByName('Promotion')->details;
        return view('home.index', compact(
            'homeCategoryOpen', 'sliders', 'bestSellers', 'specials', 'forusers', 'favorites', 'promotions'
        ));
    }

    public function search_post(Request $request)
    {
        if ($request->input('search') == '') return redirect()->route('/');
        return redirect()->route('products', ['search=' . $request->input('search'), 'category=' . $request->input('category')]);
    }

    public function products(Request $request)
    {
        $title = __('layout.product');

        $latestProducts = $this->productRepository->getLatestProduct();

        $category = null;
        $search_keyword = '';
        $parameters = [];

        if ($request->has('search')) {
            $search_keyword = $request->get('search');
            array_push($parameters, ['column' => 'name', 'value' => '%' . $search_keyword . '%', 'operator' => 'like']);
        }

        $search_category = $request->get('category');
        if ($search_category != '' && $search_category != 'all') {
            $category = $this->productRepository->getCategoryBySlug($search_category);
            if ($search_keyword == '') $title = $category->name;
            $listCategoryId = array($category->id);
            foreach ($category->sub as $subCategory) {
                array_push($listCategoryId, $subCategory->id);
            }
            array_push($parameters, ['column' => 'product_category_id', 'value' => $listCategoryId, 'custom' => 'in_array']);
        }

        $products = $this->productRepository->getProduct($parameters, null, 12);
        $maxPrice = $this->productRepository->getMaxPrice($parameters);

        return view('home.products', compact(
            'title', 'latestProducts', 'category', 'products', 'search_category', 'search_keyword', 'maxPrice'
        ));
    }

    public function category($slug)
    {
        $category = $this->productRepository->getCategoryBySlug($slug);
        if (empty($category)) return abort(404);

        $title = $category->name;

        $latestProducts = $this->productRepository->getLatestProduct();

        $listCategoryId = array($category->id);
        foreach ($category->sub as $subCategory) {
            array_push($listCategoryId, $subCategory->id);
        }
        $parameters = array(['column' => 'product_category_id', 'value' => $listCategoryId, 'custom' => 'in_array']);
        $products = $this->productRepository->getProduct($parameters, null, 12);
        $maxPrice = $this->productRepository->getMaxPrice($parameters);

        return view('home.products', compact(
            'title', 'latestProducts', 'category', 'products', 'maxPrice'
        ));
    }

    public function product(Request $request, $slug)
    {
        $product = $this->productRepository->getProductBySlug($slug);
        if (empty($product)) return abort(404);
        $title = $product->name;


        if ($request->has('quickview'))
            return view('home._product_quickview', compact('slug', 'product'));
        else
            return view('home.product', compact('title', 'slug', 'product'));
    }

    public function cart_search(CartSearchRequest $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        $parameters = array(['column' => 'user_id', 'value' => Auth::user()->id]);
        $userCarts = $this->cartRepository->search($parameters);
        if ($request->has('count')) return count($userCarts);
        if ($request->has('ajax')) return $userCarts;
        return view('home._cart_dropdown', compact('userCarts'));
    }

    public function cart_save(CartSaveRequest $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        $product = $this->productRepository->getProductStock($request->get('product_id'));
        if ($product == false) return abort(404);
        $qty = $request->has('qty') ? $request->input('qty') : 1;
        $this->cartRepository->save(Auth::user()->id, $request->input('product_id'), $qty);
        return redirect()->back();
    }

    public function cart_delete(CartDeleteRequest $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        $userCart = $this->cartRepository->find($request->input('id'));
        if (empty($userCart)) return abort(404);
        $userCart->delete($request->get('id'));
        return redirect()->back();
    }

    public function wishlist_search(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        $parameters = array(['column' => 'user_id', 'value' => Auth::user()->id]);
        return $this->wishlistRepository->search($parameters, $request->has('paginate'));
    }

    public function wishlist_save(WishlistSaveRequest $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        $product = $this->productRepository->getProductStock($request->get('product_id'));
        if ($product == false) return abort(404);
        $this->wishlistRepository->save(Auth::user()->id, $request->input('product_id'));
        return redirect()->back();
    }

    public function wishlist_delete(WishlistDeleteRequest $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        $userWishlist = $this->wishlistRepository->find($request->input('id'));
        if (empty($userWishlist)) return abort(404);
        $userWishlist->delete($request->get('id'));
        return redirect()->back();
    }

    public function wishlist()
    {


        $wishlistRequest = new Request();
        $wishlistRequest->merge(['user_id' => Auth::user()->id]);
        $wishlists = $this->wishlist_search($wishlistRequest);
        return view('home.wishlist', compact( 'wishlists'));
    }

    public function cart()
    {


        $cartRequest = new CartSearchRequest();
        $cartRequest->merge(['user_id' => Auth::user()->id]);
        $cartRequest->merge(['ajax' => 1]);
        $carts = $this->cart_search($cartRequest);

        return view('home.cart', compact( 'carts'));
    }

    public function cart_update(CartUpdateRequest $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        $this->cartRepository->update($request->input('id'), $request->input('qty'));
        return "success";
    }

    public function shipping_cost(Request $request)
    {
        if (!Auth::check()) return abort(403);
        if (!$request->has('store_id')) return abort(404);
        if (!$request->has('weight')) return abort(404);

        $store = $this->storeRepository->find($request->input('store_id'));
        $city_store = $this->courierRepository->get_city($store->city);
        $default_address = Auth::user()->default_address;
        $city = $this->courierRepository->get_city($default_address->city);
        return $this->courierRepository->shipping_cost($city->city_id, $city_store->city_id, $request->input('weight'));
    }

    public function checkout_save(Request $request)
    {
        if (!Auth::check()) return abort(403);
        $user_id = Auth::user()->id;
        $no_purchase = date('YmdHis') . $user_id;

        $stores = json_decode($request->input('stores'));
        $courier_services = json_decode($request->input('courier_services'));
        if (count($stores) != count($courier_services)) return redirect()->back()->withErrors([__('layout.alert_courier')]);

        $cartRequest = new CartSearchRequest();
        $cartRequest->merge(['user_id' => $user_id]);
        $cartRequest->merge(['ajax' => 1]);
        $carts = $this->cart_search($cartRequest);

        $weights = [];
        $storeId = '';
        foreach ($carts as $cart) {
            if($cart->product->store_id != $storeId) $weights[$cart->product->store_id] = 0;

            $weights[$cart->store_id] += ($cart->product->weight * $cart->qty);
        }

        $shipping_cost = unformat_number($request->input('shipping_cost'));
        $purchase = $this->purchaseRepository->save_purchase($user_id, $no_purchase, $shipping_cost);
        foreach ($carts as $cart) {
            $index = null;
            foreach ($courier_services as $key => $courier_service) {
                if ($courier_service->id == $cart->product->store_id) $index = $key;
            }
            $courier_service = $this->courierRepository->find_service($courier_services[$index]->value, 'name');

            $cost = $this->selected_cost($cart->product->store_id, $weights[$cart->product->store_id], $courier_service->name);

            $this->purchaseRepository->save_purchase_details(
                $purchase->id, $cart->product_id, $cart->qty, $cart->product->price,
                $cost, $courier_service->id
            );
        }

        $this->purchaseRepository->save_status($purchase->id, 0);
        $this->cartRepository->empty_cart($user_id);

        return redirect()->route('checkout', 'no_order=' . $purchase->no_purchase);
    }

    public function selected_cost($store_id, $weight, $service_name)
    {
        $request = new Request();
        $request->merge(['store_id' => $store_id]);
        $request->merge(['weight' => $weight]);
        $costs = $this->shipping_cost($request)[0];
        foreach ($costs['costs'] as $cost) {
            if ($cost['service'] == $service_name) return $cost['cost'][0]['value'];
        }
    }

    public function checkout(Request $request)
    {
        if (!$request->has('no_order')) return abort(404);


        $purchase = $this->purchaseRepository->find($request->get('no_order'), 'no_purchase');
        $details = $purchase->details;
        $paymentTypes = $this->purchaseRepository->get_payment_type();
        return view('order.checkout', compact( 'purchase', 'details', 'paymentTypes'));
    }

    public function payment_save(Request $request)
    {
        if (!$request->has('purchase_id')) return abort(404);
        if (!$request->has('payment_type_id')) return abort(404);
        $purchase = $this->purchaseRepository->find($request->input('purchase_id'));
        $details = $purchase->details;
        $request->merge(['sub_total' => $details->sum('total_price')]);
        $request->merge(['shipping' => $purchase->shipping_cost]);
        $request->merge(['tax' => 0]);
        $request->merge(['unique_code' => $request->input('unique_code')]);
        $total = $details->sum('total_price') + $purchase->shipping_cost + intval( $request->input('unique_code'));
        $request->merge(['total' => $total]);
        $this->purchaseRepository->save_payment($request);
        return redirect()->route('order.detail', 'no_order=' . $purchase->no_purchase);
    }

    public function payment_receipt(Request $request)
    {
        if (!$request->has('no_order')) return abort(404);

        $purchase = $this->purchaseRepository->find($request->get('no_order'), 'no_purchase');
        $payment = $purchase->purchase_payment;

        return view('order.payment_receipt', compact('purchase', 'payment'));
    }

    public function payment_receipt_save(Request $request)
    {
        if (!$request->has('payment_id')) return abort(404);

        $payment = $this->purchaseRepository->upload_payment_receipt($request->input('payment_id'), $request);
        $purchase = $this->purchaseRepository->find($payment->purchase_id);
        return redirect()->route('order.detail', 'no_order=' . $purchase->no_purchase);
    }

    public function order_detail(Request $request)
    {
        if (!$request->has('no_order')) return abort(404);
        $purchase = $this->purchaseRepository->find($request->get('no_order'), 'no_purchase');
        if (empty($purchase)) return abort(404);
        if ($purchase->user_id != Auth::user()->id) return abort(404);

        return view('order.detail', compact('purchase'));
    }
}
