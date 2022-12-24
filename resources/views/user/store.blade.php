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
                        <div class="card">
                            <div class="card-body p-3">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td class="p-0" width="120px"><img src="{{ $store->logo_location }}" alt="" class="img-fluid" style="height: 100px;" /></td>
                                        <td class="p-1">
                                            <h5>{{ $store->name }}</h5>
                                            {{ $store->address . ', ' . $store->province . ', ' . $store->city }} <br>
                                            No.Telp : {{ $store->phone }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <h5 class="mb-1 mt-3">Transaksi Baru</h5>
                        <div class="card">
                            <div class="card-table">
                                <div class="table-responsive-sm">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>{{ __('model.no_order') }}</th>
                                            <th>{{ __('model.date') }}</th>
                                            <th>Produk</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactions as $transaction)
                                                <tr>
                                                    <td>#{{ $transaction->purchase->no_purchase }}</td>
                                                    <td class="text-nowrap">{{ fulldate($transaction->purchase->created_at) }}</td>
                                                    <td>{{ $transaction->jumlah_toko }} Produk</td>
                                                    <td>
                                                        @if($transaction->check_shipment == 1)
                                                            Sudah Dikirim
                                                        @else
                                                            {{ $transaction->purchase->status_list[0]->status }}
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ route('user.store.transaction.detail', 'no_order=' . $transaction->purchase->no_purchase) }}">Detail</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
