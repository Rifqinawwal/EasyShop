@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
    <div class="container py-5">
        <h1 class="fw-bold">Checkout</h1>
        <div class="row mt-4">
            <div class="col-md-7">
                <h4>Ringkasan Pesanan</h4>
                <table class="table align-middle">
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cartItems as $item)
                            @php $subtotal = $item->product->price * $item->quantity; $total += $subtotal; @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('products/' . $item->product->image) }}" width="60" class="me-3 rounded">
                                        <div>
                                            <div class="fw-bold">{{ $item->product->name }}</div>
                                            <div class="text-muted small">Size: {{ $item->product->size }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm" style="width: 120px;">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="action" value="decrease">
                                            <button type="submit" class="btn btn-outline-secondary">-</button>
                                        </form>
                                        <input type="text" class="form-control text-center" value="{{ $item->quantity }}" readonly>
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="action" value="increase">
                                            <button type="submit" class="btn btn-outline-secondary">+</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="text-end fw-bold">Rp {{ number_format($subtotal) }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">&times;</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="fw-bold">
                            <td colspan="2">Total Pembayaran</td>
                            <td class="text-end text-success" colspan="2">Rp {{ number_format($total) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-5">
                <h4>Detail Pengiriman & Pembayaran</h4>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Penerima</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label fw-semibold">Alamat Pengiriman</label>
                                <button type="button" id="use-current-location" class="btn btn-sm btn-outline-secondary d-block mb-2">
                                    <span class="material-symbols-outlined" style="font-size: 1em; vertical-align: middle;">my_location</span>
                                    Gunakan Lokasi Saat Ini
                                </button>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <div id="map" style="height: 250px; width: 100%;" class="mt-2 rounded mb-3"></div>
                            <div class="mb-3">
                                <label for="payment_method" class="form-label fw-semibold">Metode Pembayaran</label>
                                <select class="form-select" id="payment_method" name="payment_method">
                                    <option value="bank_transfer">Transfer Bank</option>
                                    <option value="cod">Cash on Delivery (COD)</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Buat Pesanan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('map').setView([-6.2088, 106.8456], 13);
        const addressTextarea = document.getElementById('address');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const marker = L.marker([-6.2088, 106.8456], { draggable: true }).addTo(map);
        marker.bindPopup("<b>Lokasi Pengiriman</b><br>Geser marker untuk menyesuaikan.").openPopup();

        // FUNGSI UNTUK MENGAMBIL ALAMAT DARI KOORDINAT
        function fetchAddress(lat, lng) {
            addressTextarea.value = 'Mencari alamat...';
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    addressTextarea.value = data.display_name || "Alamat tidak ditemukan.";
                })
                .catch(error => {
                    console.error('Error fetching address:', error);
                    addressTextarea.value = "Gagal mengambil alamat.";
                });
        }

        // Event listener saat marker selesai digeser
        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            fetchAddress(position.lat, position.lng);
        });

        // Logika Tombol 'Gunakan Lokasi Saat Ini'
        const locationButton = document.getElementById('use-current-location');
        locationButton.addEventListener('click', function() {
            if ('geolocation' in navigator) {
                locationButton.disabled = true;
                locationButton.innerHTML = 'Mencari lokasi...';

                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    map.setView([lat, lng], 17);
                    marker.setLatLng([lat, lng]);
                    fetchAddress(lat, lng); // Panggil fungsi yang sama

                    locationButton.disabled = false;
                    locationButton.innerHTML = '<span class="material-symbols-outlined" style="font-size: 1em; vertical-align: middle;">my_location</span> Gunakan Lokasi Saat Ini';
                }, function(error) {
                    alert('Gagal mendapatkan lokasi. Pastikan Anda mengizinkan akses lokasi di browser.');
                    locationButton.disabled = false;
                    locationButton.innerHTML = '<span class="material-symbols-outlined" style="font-size: 1em; vertical-align: middle;">my_location</span> Gunakan Lokasi Saat Ini';
                });
            } else {
                alert('Geolocation tidak didukung oleh browser Anda.');
            }
        });
    });
</script>
@endpush