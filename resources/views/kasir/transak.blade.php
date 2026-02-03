<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kasir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #ececec;
        }
        .sidebar {
            min-height: 100vh;
        }
        .sidebar a {
            text-decoration: none;
            color: #fff;
        }
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <nav class="col-md-2 d-none d-md-block bg-dark sidebar p-3 position-fixed">
            <h5 class="text-white text-center mb-4">Kasir</h5>
            <ul class="nav flex-column gap-2">
                <li class="nav-item">
                    <a class="nav-link text-white active" href="{{ url('/dash') }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/rekap') }}">
                        <i class="bi bi-cart-check me-2"></i> Rekap Penjualan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/produk') }}">
                        <i class="bi bi-box-seam me-2"></i> Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/tran') }}">
                        <i class="bi bi-receipt me-2"></i> Transaksi
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-danger" href="{{ url('/') }}">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- MAIN CONTENT -->
       <main class="col-md-10 ms-sm-auto px-4">

    <!-- TOP NAVBAR -->
    <nav class="navbar navbar-dark bg-dark shadow-sm rounded my-3 px-3">
        <span class="navbar-brand h5 mb-0">Transaksi</span>
    </nav>

    <!-- HEADER -->
    {{-- <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Mesin Kasir</h4>
        </div>
    </div> --}}

    <div class="container-fluid p-4">
        <div class="row">

            <!-- FORM & PRODUK -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">

                        <h5 class="mb-3">Kasir</h5>

                        <!-- FORM TRANSAKSI -->
                        <form id="transaksiForm" action="{{ route('transaksi.simpan') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Pelanggan</label>
                                    <input type="text" name="nama_pelanggan" class="form-control"
                                           placeholder="Umum / Nama pelanggan" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control"
                                           value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Telepon</label>
                                    <input type="text" name="telepon" class="form-control"
                                           placeholder="Masukkan no telepon">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" name="alamat" class="form-control"
                                           placeholder="Masukkan alamat">
                                </div>
                            </div>

                            <!-- Input tersembunyi untuk produk -->
                            <div id="produkInput"></div>
                        </form>

                        <!-- TABEL PRODUK -->
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($barang as $item)
                                        <tr>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm tambahKeranjang"
                                                    data-id="{{ $item->id_barang }}"
                                                    data-nama="{{ $item->nama_barang }}"
                                                    data-harga="{{ $item->harga }}"
                                                    data-stok="{{ $item->stok }}">
                                                    <i class="bi bi-cart3"></i> Keranjang
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">Tidak ada produk</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- KERANJANG -->
                        <div class="mt-4">
                            <h6>Keranjang Pesanan</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="keranjangTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="keranjangKosong">
                                            <td colspan="5">Keranjang kosong</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- PEMBAYARAN -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Pembayaran</h5>

                        <div class="mb-3">
                            <label class="form-label">Subtotal</label>
                            <input type="text" id="subtotal" class="form-control text-end fs-4" value="Rp 0" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total</label>
                            <input type="hyden" name="total" id="total" class="form-control text-end fs-4" value="Rp 0" readonly>
                            <input type="text" id="total_display"class="form-control text-end fs-4"value="Rp 0" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bayar</label>
                            <input type="number" id="bayar" class="form-control" placeholder="Masukkan uang bayar">
                        </div>
 
                        {{-- <div class="mb-3">
                            <label class="form-label">Kembalian</label>
                            <input type="number" id="kembalian" class="form-control" readonly>
                        </div> --}}

                        <div class="d-grid gap-2">
                            <button type="submit" form="transaksiForm" class="btn btn-success btn-lg"
                                    onclick="return hitungKembalian()"> Bayar
                            </button>
                            <button class="btn btn-secondary btn-lg" onclick="resetTransaksi()">
                                Reset
                            </button>
                                @php
                                $kodeTransaksi = session('kode_transaksi');
                                @endphp

                                @if ($kodeTransaksi)
                                    <a href="{{ route('struk.download', $kodeTransaksi) }}"
                                    class="btn btn-primary btn-lg">
                                        Download Struk
                                    </a>
                                @endif

                            {{-- @if(isset($id_transaksi) && $id_transaksi)
                                <a href="{{ route('struk.download', ['id' => $id_transaksi]) }}"
                                class="btn btn-primary btn-lg">
                                    Download Struk
                                </a>
                            @else
                                <button class="btn btn-primary btn-lg" disabled>
                                    Download Struk
                                </button>
                            @endif --}}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</main>

<script>
let keranjang = [];
let indexProduk = 0;

// Cek session untuk alert success
@if (session('success'))
    Swal.fire({
        title: 'Sukses!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'OK'
    });
@endif

// Cek session untuk alert error
@if (session('error'))
    Swal.fire({
        title: 'Error!',
        text: "{{ session('error') }}",
        icon: 'error',
        confirmButtonText: 'OK'
    });
@endif

document.querySelectorAll('.tambahKeranjang').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const nama = this.dataset.nama;
        const harga = parseInt(this.dataset.harga);
        const stok = parseInt(this.dataset.stok);

        // Cek apakah stok habis
        if (stok <= 0) {
            Swal.fire({
                title: 'Stok Habis!',
                text: `Stok untuk ${nama} tidak tersedia`,
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        let item = keranjang.find(p => p.id_produk == id);

        if (item) {
            // Cek apakah jumlah yang diminta melebihi stok
            if (item.jumlah >= stok) {
                Swal.fire({
                    title: 'Stok Tidak Cukup!',
                    text: `Stok ${nama} hanya tersedia ${stok} unit. Anda sudah menambahkan ${item.jumlah} unit.`,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }
            item.jumlah++;
            item.subtotal = item.jumlah * harga;
        } else {
            keranjang.push({
                id_produk: id,
                nama,
                harga,
                jumlah: 1,
                subtotal: harga
            });
        }

        renderKeranjang();
    });
});

function renderKeranjang() {
    const tbody = document.querySelector('#keranjangTable tbody');
    const inputDiv = document.getElementById('produkInput');

    tbody.innerHTML = '';
    inputDiv.innerHTML = '';
    let total = 0;

    keranjang.forEach((item, index) => {
        total += item.subtotal;

        tbody.innerHTML += `
            <tr>
                <td>${item.nama}</td>
                <td>Rp ${item.harga.toLocaleString()}</td>
                <td>${item.jumlah}</td>
                <td>Rp ${item.subtotal.toLocaleString()}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="hapus(${index})">Hapus</button>
                </td>
            </tr>
        `;

        inputDiv.innerHTML += `
            <input type="hidden" name="produk[${index}][id_produk]" value="${item.id_produk}">
            <input type="hidden" name="produk[${index}][jumlah]" value="${item.jumlah}">
            <input type="hidden" name="produk[${index}][subtotal]" value="${item.subtotal}">
        `;
    });
    document.getElementById('total').value = total;
    document.getElementById('subtotal').value = 'Rp ' + total.toLocaleString();
    document.getElementById('total').value = 'Rp ' + total.toLocaleString();
}

function hapus(index) {
    keranjang.splice(index, 1);
    renderKeranjang();
}

// Fungsi validasi pembayaran dan hitung kembalian
function hitungKembalian() {
    // Validasi: Keranjang tidak boleh kosong
    if (keranjang.length === 0) {
        Swal.fire({
            title: 'Keranjang Kosong!',
            text: 'Tambahkan produk ke keranjang terlebih dahulu',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return false;
    }

    // Validasi: Nama pelanggan harus diisi
    const namaPelanggan = document.querySelector('input[name="nama_pelanggan"]').value;
    if (!namaPelanggan.trim()) {
        Swal.fire({
            title: 'Data Tidak Lengkap!',
            text: 'Masukkan nama pelanggan terlebih dahulu',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return false;
    }

    // Validasi: Uang bayar harus diisi
    const bayar = parseInt(document.getElementById('bayar').value) || 0;
    const total = parseInt(document.getElementById('total').value) || 0;
    
    if (bayar === 0) {
        Swal.fire({
            title: 'Uang Bayar Diperlukan!',
            text: 'Masukkan jumlah uang yang dibayarkan',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return false;
    }

    // Validasi: Uang bayar tidak boleh kurang dari total
    if (bayar < total) {
        Swal.fire({
            title: 'Uang Tidak Cukup!',
            text: `Total harus dibayar Rp ${total.toLocaleString()}. Anda hanya membayar Rp ${bayar.toLocaleString()}`,
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    }

    // Jika semua validasi lolos, submit form
    return true;
}

// Fungsi reset transaksi
function resetTransaksi() {
    Swal.fire({
        title: 'Reset Transaksi?',
        text: 'Apakah Anda yakin ingin menghapus semua data transaksi?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            keranjang = [];
            renderKeranjang();
            document.querySelector('input[name="nama_pelanggan"]').value = '';
            document.querySelector('input[name="telepon"]').value = '';
            document.querySelector('input[name="alamat"]').value = '';
            document.getElementById('bayar').value = '';
            Swal.fire({
                title: 'Berhasil!',
                text: 'Transaksi telah direset',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
    });
}
</script>



</body>
</html>
