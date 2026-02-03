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
        <nav class="col-md-2 d-none d-md-block bg-dark sidebar p-3" style="position: fixed">
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
                        <i class="bi bi-receipt me-2"></i> tranksaksi
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
            <nav class="navbar navbar-dark bg-dark shadow-sm rounded my-3 px-3" ">
                <span class="navbar-brand mb-0 h5">produk </span>
                {{-- <span class="text-muted">Login sebagai: <strong>Kasir</strong></span> --}}
            </nav>

            <!-- Navbar -->

        

            <!-- Search -->
            {{-- <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-4" style="width: 800px">
                            <input type="text" class="form-control" placeholder="Cari nama produk...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-secondary w-100">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Table -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-striped align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                {{-- <th>Gambar</th> --}}
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barang as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td class="text-capitalize">{{ $item->kategori }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>
                                       <!-- EDIT -->
                                        <a href="{{ route('produk.edit', $item->id_barang) }}" 
                                        class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <!-- DELETE -->
                                        <form action="{{ route('produk.destroy', $item->id_barang) }}" 
                                            method="POST"
                                            onsubmit="return confirm('Yakin hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Data produk belum tersedia
                                    </td>
                                </tr>
                             @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- form tambah produk --}}
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">

                                <h4 class="mb-4 fw-bold">Tambah Produk</h4>

                              <form action="{{ route('produk.store') }}" method="POST">
                                    @csrf

                                    <!-- Nama Produk -->
                                    <div class="mb-3">
                                        <label class="form-label">Nama Produk</label>
                                        <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan nama produk">
                                    </div>

                                    <!-- Kode Produk -->
                                    {{-- <div class="mb-3">
                                        <label class="form-label">Kode Produk</label>
                                        <input type="text" name="kode_produk" class="form-control" placeholder="PRD-001">
                                    </div> --}}

                                    <!-- Kategori -->
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="kategori" class="form-select" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <option value="makanan">-- Makanan --</option>
                                            <option value="minuman">-- Minuman --</option>
                                            {{-- @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->nama_barang }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>

                                    <div class="row">
                                        <!-- Harga Beli -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Harga </label>
                                            <input type="number" name="harga" class="form-control">
                                        </div>

                                        <!-- Harga Jual -->
                                        {{-- <div class="col-md-6 mb-3">
                                            <label class="form-label">Harga Jual</label>
                                            <input type="number" name="harga_jual" class="form-control">
                                        </div> --}}
                                    </div>

                                    <div class="row">
                                        <!-- Stok -->
                                        <div class="col-md-13 mb-3">
                                            <label class="form-label">Stok</label>
                                            <input type="number" name="stok" class="form-control">
                                        </div>

                                        <!-- Satuan -->
                                        {{-- <div class="col-md-6 mb-3">
                                            <label class="form-label">Satuan</label>
                                            <input type="text" name="satuan" class="form-control" placeholder="pcs / box / kg">
                                        </div> --}}
                                    </div>

                                    <!-- Deskripsi -->
                                    {{-- <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi" rows="3" class="form-control"></textarea>
                                    </div> --}}

                                    <!-- Gambar Produk -->
                                    {{-- <div class="mb-4">
                                        <label class="form-label">Gambar Produk</label>
                                        <input type="file" name="gambar" class="form-control">
                                    </div> --}}

                                    <!-- Tombol -->
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="" class="btn btn-danger">
                                            Batal
                                        </a>
                                        <button type="submit" class="btn btn-success">
                                            Simpan Produk
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </main>
    
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
