<?php

namespace App\Repositories;

use App\Purchase;
use App\PurchaseStatus;
use App\Shipment;
use App\ShipmentStatus;
use Illuminate\Http\Request;

class ShipmentRepository extends BaseRepository
{
    private $shipment;
    private $purchase;
    private $shipmentStatus;
    private $purchaseStatus;
    public function __construct(Shipment $shipment, Purchase $purchase, ShipmentStatus $shipmentStatus, PurchaseStatus $purchaseStatus)
    {
        $this->shipment = $shipment;
        $this->purchase = $purchase;
        $this->shipmentStatus = $shipmentStatus;
        $this->purchaseStatus = $purchaseStatus;
    }

    public function save(Request $request)
    {
        $shipment = $this->shipment->create($request->all());
        $purchase = $this->purchase->find($shipment->purchase_id);
        if (count($shipment->shipment_status) == 0) {
            $this->shipmentStatus->create([
                'shipment_id' => $shipment->id,
                'status' => 'Barang Diserakan ke Kurir',
                'description' => 'Barang sudah diserahkan ke kurir dan mendapatkan nomor resi',
            ]);
        }


        if ($this->check_store_shipment($purchase, $shipment->store) == 0) {
            $this->purchaseStatus->create([
                'purchase_id' => $purchase->id,
                'status' => $shipment->store->name . ' Sudah Mengirim',
                'description' => 'No.Resi dari toko ' . $shipment->store->name . ' adalah : ' . $shipment->no_shipment
            ]);
        }
        return $shipment;
    }

    public function check_store_shipment($purchase, $store)
    {
        return $this->purchaseStatus->where('purchase_id', '=', $purchase->id)
            ->where('status', 'like', '%'. $store->name .'%')->count();
    }

    public function get_store_shipment($purchase, $store)
    {
        return $this->shipment->where('purchase_id', '=', $purchase->id)
            ->where('store_id', '=', $store->id)->first();
    }
}
