<?php

namespace App\Repositories;

use App\PaymentType;
use App\Purchase;
use App\PurchaseDetail;
use App\PurchasePayment;
use App\PurchaseStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PurchaseRepository extends BaseRepository
{

    private $statuses = [
        ['status' => 'Menunggu Pembayaran', 'desciption' => 'Menunggu proses pembayaran dari pembeli'],
        ['status' => 'Menunggu Bukti Pembayaran', 'desciption' => 'Menunggu bukti pembayaran dari pembeli'],
        ['status' => 'Menunggu Konfirmasi', 'desciption' => 'Menunggu konfirmasi pembayaran dari admin'],
        ['status' => 'Pembayaran Diverifikasi', 'desciption' => 'Pembayaran sudah diverifikasi, menunggu proses dari toko'],
        ['status' => 'Pembayaran Ditolak', 'desciption' => 'Bukti Pembayaran Tidak Sesuai / Salah, Silahkah Upload Ulang'],
        ['status' => 'Pembelian Diproses', 'desciption' => 'Pembelian sedang diproses oleh toko'],
        ['status' => 'Pembelian Dikirim', 'desciption' => 'Pembelian sedang dikirim oleh kurir'],
        ['status' => 'Pembelian Selesai', 'desciption' => 'Pembelian sudah sampai dipelanggan'],
        ['status' => 'Sudah Direview', 'desciption' => 'Pembeli sudah mereview produk'],
    ];

    private $purchase;
    private $purchaseDetail;
    private $purchaseStatus;
    private $paymentType;
    private $purchasePayment;
    public function __construct(Purchase $purchase,
                                PurchaseDetail $purchaseDetail,
                                PurchaseStatus $purchaseStatus,
                                PaymentType $paymentType,
                                PurchasePayment $purchasePayment)
    {
        $this->purchase = $purchase;
        $this->purchaseDetail = $purchaseDetail;
        $this->purchaseStatus = $purchaseStatus;
        $this->paymentType = $paymentType;
        $this->purchasePayment = $purchasePayment;
    }

    public function save_purchase($user_id, $no_purchase, $shipping_cost)
    {
        return $this->purchase->firstOrCreate([
            'user_id' => $user_id,
            'no_purchase' => $no_purchase,
            'user_address_id' => Auth::user()->default_address->id,
            'shipping_cost' => $shipping_cost,
            'status' => ''
        ]);
    }

    public function save_purchase_details($purchase_id, $product_id, $qty, $price, $shipping_cost, $courier_service_id)
    {
        return $this->purchaseDetail->create([
            'purchase_id' => $purchase_id,
            'product_id' => $product_id,
            'qty' => $qty,
            'price' => $price,
            'shipping_cost' => $shipping_cost,
            'courier_service_id' => $courier_service_id
        ]);
    }

    public function get_all($parameters = null, $orders = null, $paginate = false)
    {
        $purchases = $this->purchase->select('purchases.*')
            ->with('details');
        $purchases = $this->setParameter($purchases, $parameters);
        $purchases = $this->setOrder($purchases, $orders);
        return $paginate == false ? $purchases->get() : $purchases->paginate(10);
    }

    public function find($value, $column = 'id')
    {
        return $this->purchase->where($column, '=', $value)->first();
    }

    public function save_status($purchase_id, $statusIndex)
    {
        $this->purchaseStatus->create([
            'purchase_id' => $purchase_id,
            'status' => $this->statuses[$statusIndex]['status'],
            'description' => $this->statuses[$statusIndex]['desciption'],
        ]);
    }

    public function search($parameters = null, $orders = null, $paginate = null)
    {
        $purchase = $this->purchaseDetail->select('purchase_details.*')
            ->join('products', 'products.id', '=', 'purchase_details.product_id')
            ->join('purchases', 'purchases.id', '=', 'purchase_details.purchase_id')
            ->with('purchase', 'product');
        $purchase = $this->setParameter($purchase, $parameters);
        $purchase = $this->setOrder($purchase, $orders);
        if ($paginate == null) return $purchase->get();
        return $purchase->paginate($paginate);
    }

    public function get_payment_type()
    {
        return $this->paymentType->get();
    }

    public function save_payment(Request $request)
    {
        $payment = $this->purchasePayment->firstOrNew([
            'purchase_id' => $request->input('purchase_id')
        ]);
        $payment->payment_type_id = $request->input('payment_type_id');
        $payment->sub_total = $request->input('sub_total');
        $payment->shipping = $request->input('shipping');
        $payment->tax = $request->input('tax');
        $payment->total = $request->input('total');
        $payment->unique_code = $request->input('unique_code');
        $payment->save();

        $purchase = $this->purchase->find($payment->purchase_id);
        if (count($purchase->status_list) == 1) {
            $purchase->status = 'waiting payment receipt';
            $purchase->save();
            $this->save_status($purchase->id, 1);
        }
    }

    public function upload_payment_receipt($id, Request $request)
    {
        $payment = $this->purchasePayment->find($id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::random(6).'_' . $payment->id . '.'. $image->extension();
            $path = Storage::putFileAs('receipt', $image, $filename);
            $payment->payment_receipt = $path;
            $payment->save();

            $purchase = $this->purchase->find($payment->purchase_id);
            if (count($purchase->status_list) == 2 || $purchase->status_list[0]->status == 'Pembayaran Ditolak') {
                $purchase->status = 'waiting payment confirmation';
                $purchase->save();
                $this->save_status($purchase->id, 2);
            }
        }
        return $payment;
    }

    public function verify_purchase($id)
    {
        $this->save_status($id, 3);
        $purchase = $this->purchase->find($id);
        $purchase->status = 'payment_verified';
        $purchase->save();
    }

    public function reject_purchase($id)
    {
        $this->save_status($id, 4);
    }

    public function search_detail_with_group($parameters = null, $orders = null, $paginate = null)
    {
        $purchase = $this->purchaseDetail->select('purchase_details.*', DB::raw('count(*) as jumlah_toko'))
            ->join('products', 'products.id', '=', 'purchase_details.product_id')
            ->join('purchases', 'purchases.id', '=', 'purchase_details.purchase_id')
            ->with('purchase', 'product')
            ->groupBy('purchase_id');
        $purchase = $this->setParameter($purchase, $parameters);
        $purchase = $this->setOrder($purchase, $orders);
        if ($paginate == null) return $purchase->get();
        return $purchase->paginate($paginate);
    }

}
