@extends('sbadmin2.sbadmin')

@section('title')
Daftar Transaksi Penjualan Apotek Milan
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Transaksi Penjualan Apotek Milan</h1>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Tabel Katalog Obat -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Katalog Obat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>Harga Satuan</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obat as $item)
                        <tr>
                            <td>{{ $item->kode_obat }}</td>
                            <td>{{ $item->nama_obat }}</td>
                            <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->jmlh_stok }}</td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="addToCart({{ $item->id }}, '{{ $item->nama_obat }}', {{ $item->harga }})">
                                    Tambah ke Keranjang
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Tabel Katalog Obat -->

    <!-- Keranjang Belanja -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Keranjang Belanja</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('penjualan.store') }}" method="POST">
                @csrf
                <table class="table table-bordered" id="cartTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="cartBody">
                        <!-- Data keranjang ditampilkan di sini -->
                    </tbody>
                </table>
                <div class="form-group">
                    <label for="tgl_jual">Tanggal Jual</label>
                    <input type="date" class="form-control" name="tgl_jual" required>
                </div>
                <div class="form-group">
                    <label for="pelanggan_id">Pilih Pelanggan</label>
                    <select class="form-control" name="pelanggan_id" required>
                        <option value="">Pilih Pelanggan</option>
                        @foreach ($pelanggan as $pel)
                        <option value="{{ $pel->id }}">{{ $pel->nama_pelanggan }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="cart_data" id="cartData">
                <button type="submit" class="btn btn-primary">Checkout</button>
            </form>
        </div>
    </div>
    <!-- End Keranjang Belanja -->

    <!-- Riwayat Transaksi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="riwayatTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No Transaksi</th>
                            <th>Tanggal Jual</th>
                            <th>Pelanggan</th>
                            <th>Obat</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $transaksi)
                        @foreach ($transaksi->detailPenjualan as $key => $detail)
                        <tr>
                            @if ($key === 0)
                            <td rowspan="{{ $transaksi->detailPenjualan->count() }}">{{ $transaksi->no_trans }}</td>
                            <td rowspan="{{ $transaksi->detailPenjualan->count() }}">{{ $transaksi->tgl_jual }}</td>
                            <td rowspan="{{ $transaksi->detailPenjualan->count() }}">
                                {{ optional($transaksi->pelanggan)->nama_pelanggan ?? '-' }}
                            </td>
                            @endif
                            <td>{{ optional($detail->obat)->nama_obat ?? '-' }}</td>
                            <td>{{ $detail->jmlh_jual }}</td>
                            <td>{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td>{{ number_format($detail->total_jual, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Riwayat Transaksi -->


</div>

<!-- JavaScript untuk Keranjang -->
<script>
    let cart = [];

    function addToCart(id, nama, harga) {
        let existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            existingItem.jumlah++;
            existingItem.total = existingItem.jumlah * existingItem.harga;
        } else {
            cart.push({
                id: id
                , nama: nama
                , harga: harga
                , jumlah: 1
                , total: harga
            });
        }
        updateCart();
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCart();
    }

    function updateCart() {
        let cartBody = document.getElementById('cartBody');
        cartBody.innerHTML = '';
        cart.forEach((item, index) => {
            cartBody.innerHTML += `
                <tr>
                    <td>${item.nama}</td>
                    <td>${item.harga.toLocaleString('id-ID')}</td>
                    <td>
                        <input type="number" value="${item.jumlah}" min="1" class="form-control" 
                            onchange="updateQuantity(${index}, this.value)">
                    </td>
                    <td>${item.total.toLocaleString('id-ID')}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeFromCart(${index})">Hapus</button>
                    </td>
                </tr>
            `;
        });

        // Simpan data ke input hidden untuk dikirim ke backend
        document.getElementById('cartData').value = JSON.stringify(cart);
    }

    function updateQuantity(index, jumlah) {
        cart[index].jumlah = parseInt(jumlah);
        cart[index].total = cart[index].jumlah * cart[index].harga;
        updateCart();
    }

</script>
@endsection
