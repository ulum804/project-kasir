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
                        <i class="bi bi-cart-check me-2"></i> pelanggan
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
                <span class="navbar-brand mb-0 h5">Pelanggan </span>
                {{-- <span class="text-muted">Login sebagai: <strong>Kasir</strong></span> --}}
            </nav>

            <div class="card shadow-sm mb-3">
                {{-- <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Cari nama pelanggan...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-secondary w-100">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- Table -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <h4 class="p-2">Data Pelanggan</h4>
                    <table class="table table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Total Transaksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pelanggan as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->nama_pelanggan }}</td>
                                    <td>{{ $p->telpon }}</td>
                                    <td>{{ $p->alamat }}</td>
                                    <td>
                                        {{-- Misal total transaksi dihitung dari tabel transaksi --}}
                                        {{ $p->transaksi->count() ?? 0 }}
                                    </td>
                                    <td>
                                        {{-- <a href="{{ route('pelanggan.edit', $p->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a> --}}
                                        <form action="{{ route('pelanggan.destroy', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Data pelanggan kosong</td>
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
