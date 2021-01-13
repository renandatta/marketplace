@extends('layouts.home')

@section('content')
    <div class="site__body">
        @include('user._header')
        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-3 d-flex">
                        @include('user._sidebar')
                    </div>
                    <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                        <div class="card address-card">
                            <div class="address-card__body">
                                <div class="address-card__badge address-card__badge--muted">Detail Pembeli dan Kurir Pilihan</div>
                                <br>
                                <div class="address-card__row">Nama : {{ $purchase->user->name }}</div>
                                <div class="address-card__row">Alamat : {{ $purchase->user_address->address . ', ' . $purchase->user_address->province . ', ' . $purchase->user_address->city . ', ' . $purchase->user_address->district }}</div>
                                <div class="address-card__row">Kodepos : {{ $purchase->user_address->postal_code }}</div>
                                <div class="address-card__row">No.Telp : {{ $purchase->user_address->phone }}</div>
                                <div class="address-card__row">Kurir : {{ $transactions[0]->courier_service->courier->name }}</div>
                                <div class="address-card__row">Jenis Layanan : {{ $transactions[0]->courier_service->name }}</div>
                                <div class="address-card__row">Ongkir : {{ format_number($transactions[0]->shipping_cost) }}</div>
                                @if(!empty($shipment))
                                    <div class="address-card__row">No.Resi : {{ $shipment->no_shipment }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="card address-card mt-3">
                            <div class="address-card__body">
                                <div class="address-card__badge address-card__badge--muted">List Produk</div>
                                <br>
                                <table class="table table-borderless table-sm mb-0">
                                    <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-right">Jumlah</th>
                                        <th class="text-right">Harga</th>
                                    </tr>
                                    </thead>
                                    @php($weight = 0)
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->product->name }}</td>
                                            <td class="text-right">{{ format_number($transaction->qty) }}</td>
                                            <td class="text-right">{{ format_number($transaction->price) }}</td>
                                        </tr>
                                        @php($weight += $transaction->product->weight)
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        @if(empty($shipment))
                            <div class="card address-card mt-3">
                                <div class="address-card__body">
                                    <div class="address-card__badge address-card__badge--muted">Pengiriman Barang</div>
                                    <br>
                                    <form action="{{ route('user.store.shipping.save') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                        <input type="hidden" name="courier_service_id" value="{{ $transactions[0]->courier_service_id }}">
                                        <input type="hidden" name="weight" value="{{ $weight }}">
                                        <div class="form-group mb-2">
                                            <label for="no_shipment">No.Resi</label>
                                            <input type="text" class="form-control" id="no_shipment" name="no_shipment" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan Pengiriman Barang</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
