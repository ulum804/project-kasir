<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">

            <h4 class="mb-4">Edit Produk</h4>

            <form action="{{ route('produk.update', $barang->id_barang) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_barang" class="form-control"
                           value="{{ $barang->nama_barang }}" required>
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori" class="form-select" required>
                        <option value="makanan"
                            {{ $barang->kategori == 'makanan' ? 'selected' : '' }}>
                            Makanan
                        </option>
                        <option value="minuman"
                            {{ $barang->kategori == 'minuman' ? 'selected' : '' }}>
                            Minuman
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control"
                           value="{{ $barang->harga }}" required>
                </div>

                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control"
                           value="{{ $barang->stok }}" required>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-success">Update</button>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>
