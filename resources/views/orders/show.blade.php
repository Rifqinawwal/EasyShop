@extends('layouts.main')
@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<div class="container py-5">
    <div class="card">
        <div class="card-header">
            <h2>INVOICE</h2>
            <div class="d-flex justify-content-between">
                <div>
                    <strong>KEPADA:</strong><br>
                    {{ $order->user->name }}<br>
                    {{ $order->user->email }}
                </div>
                <div class="text-end">
                    <strong>TANGGAL:</strong> {{ $order->created_at->format('d F Y') }}<br>
                    <strong>NO INVOICE:</strong> {{ $order->order_number }}
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>KETERANGAN</th>
                        <th>HARGA</th>
                        <th>JML</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>Rp {{ number_format($item->price) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price * $item->quantity) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-end">
                <div class="col-md-4">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><strong>SUB TOTAL:</strong></td>
                                <td class="text-end">Rp {{ number_format($order->total_amount) }}</td>
                            </tr>
                            <tr>
                                <td><strong>PAJAK (10%):</strong></td>
                                <td class="text-end">Rp {{ number_format($order->total_amount * 0.1) }}</td>
                            </tr>
                            <tr class="fw-bold">
                                <td><strong>TOTAL:</strong></td>
                                <td class="text-end">Rp {{ number_format($order->total_amount * 1.1) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            TERIMA KASIH ATAS PEMBELIAN ANDA
            <br>
            <button class="btn btn-success mt-3" onclick="window.print()">Cetak Nota</button>
        </div>
    </div>
</div>
@endsection