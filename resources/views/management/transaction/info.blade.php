@extends('layouts.management')

@section('title')
    Detail Transaksi
@endsection

@section('content')
    <h4>Detail Transaksi</h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td colspan="2" class="p-1">
                                <a href="{{ route('management.transaction') }}" class="btn btn-sm btn-secondary btn-block">Kembali</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-1">No. Pembelian</td>
                            <th class="p-1">: {{ $purchase->no_purchase }}</th>
                        </tr>
                        <tr>
                            <td class="p-1">Tanggal</td>
                            <th class="p-1">: {{ format_date($purchase->date) }}</th>
                        </tr>
                        <tr>
                            <td class="p-1">Nama Pembeli</td>
                            <th class="p-1">: {{ $purchase->user->name }}</th>
                        </tr>
                        <tr>
                            <td class="p-1">Alamat</td>
                            @php($address = $purchase->user_address)
                            <th class="p-1">: {{ $address->address. ', ' . $address->province. ', ' . $address->city }}</th>
                        </tr>
                        <tr>
                            <td class="p-1">Riwayat Status Pembelian</td>
                            <td class="p-1">
                                <table class="table table-borderless mb-0 float-left">
                                    @foreach($purchase->status_list as $key => $status)
                                        <tr>
                                            @if($key == 0)
                                                <th class="p-1"><i class="fa fa-fw fa-check"></i> {{ $status->status }}<br>{{ $status->description }}</th>
                                            @else
                                                <td class="p-1"><i class="fa fa-fw fa-minus"></i> {{ $status->status }}<br>{{ $status->description }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    </table>
                    @if($purchase->status_list[0]->status == 'Menunggu Konfirmasi')
                    <table class="table table-borderless">
                        <tr>
                            <td class="p-1">
                                <form action="{{ route('management.transaction.payment.verify') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                    <button type="submit" class="btn btn-sm btn-primary btn-block">Verifikasi Pembayaran</button>
                                </form>
                            </td>
                            <td class="p-1">
                                <form action="{{ route('management.transaction.payment.reject') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                    <button type="submit" class="btn btn-sm btn-danger btn-block">Tolak Pembayaran</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                    @endif
                </div>
                <div class="col-md-6">
                    <h5 class="mb-0">Daftar Produk</h5>
                    <table class="table table-bordered">
                        @foreach($purchase->details as $detail)
                            <tr>
                                <td class="p-1">
                                    {{ $detail->product->name }}
                                    <div class="row">
                                        <div class="col-6">
                                            {{ $detail->qty }} x {{ format_number($detail->price) }}
                                        </div>
                                        <div class="col-6 text-right">
                                            <b>{{ format_number($detail->total_price) }}</b>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                            <tr>
                                <td class="p-1">
                                    <div class="row">
                                        <div class="col-6">Sub Total</div>
                                        <div class="col-6 text-right">
                                            <b>{{ format_number($purchase->details->sum('total_price')) }}</b>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-1">
                                    <div class="row">
                                        <div class="col-6">Biaya Pengiriman</div>
                                        <div class="col-6 text-right">
                                            <b>{{ format_number($purchase->shipping_cost) }}</b>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @if(!empty($purchase->purchase_payment))
                            <tr>
                                <td class="p-1">
                                    <div class="row">
                                        <div class="col-6">Kode Unik</div>
                                        <div class="col-6 text-right">
                                            <b>{{ format_number($purchase->purchase_payment->unique_code) }}</b>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-1">
                                    <div class="row">
                                        <div class="col-6">Total</div>
                                        <div class="col-6 text-right">
                                            <b>{{ format_number($purchase->purchase_payment->total) }}</b>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="p-1">
                                    Bukti Pembayaran
                                    <img src="{{ asset('image/' . $purchase->purchase_payment->payment_receipt) }}" alt="" class="img-fluid">
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
