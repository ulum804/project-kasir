<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kasir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
        }
        .sidebar a {
            text-decoration: none;
            color: #fff;
        }
        .sidebar a:hover {
            background-color: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body style="background-color: #ececec">

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-dark sidebar p-3">
            <h5 class="text-white text-center mb-4">Kasir</h5>
            <ul class="nav flex-column gap-2">
                <li class="nav-item">
                    <a class="nav-link text-white active" href="{{ url('/dash') }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/rekap') }}">
                        <i class="bi bi-cart-check me-2"></i> Pelanggan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/produk') }}">
                        <i class="bi bi-box-seam me-2"></i> Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/tran') }}">
                        <i class="bi bi-receipt me-2"></i> transaksi
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-danger" href="{{ url('/') }}">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-4">

            <!-- Navbar -->
            <nav class="navbar navbar-dark bg-dark shadow-sm rounded my-3 px-3">
                <span class="navbar-brand mb-0 h5">Dashboard </span>
                {{-- <span class="text-muted">Login sebagai: <strong>Kasir</strong></span> --}}
            </nav>

            <!-- Cards -->
            {{-- <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Pendapatan Hari Ini</h6>
                            <h3>Rp 2.500.000</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Stok produk</h6>
                            <h3>125</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Produk Terjual</h6>
                            <h3>320</h3>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- rekap penjualann harian --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <strong>Rekap Penjualan Harian</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-bordered mb-0 text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Tanggal</th>
                                <th>Total Transaksi</th>
                                <th>Total Produk Terjual</th>
                                <th>Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($harian as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $item->total_transaksi }}</td>
                                    <td>{{ $item->total_produk }}</td>
                                    <td>Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- rekap penjualan bulanan --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <strong>Rekap Penjualan Bulanan</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-bordered mb-0 text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Bulan</th>
                                <th>Total Transaksi</th>
                                <th>Total Produk Terjual</th>
                                <th>Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bulanan as $item)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $item->bulan)
                                            ->translatedFormat('F Y') }}
                                    </td>
                                    <td>{{ $item->total_transaksi }}</td>
                                    <td>{{ $item->total_produk }}</td>
                                    <td>Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
