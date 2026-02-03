<?php
// scripts/test_transaction.php
// require __DIR__ . '/../vendor/autoload.php';
// $app = require_once __DIR__ . '/../bootstrap/app.php';
// $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
// $kernel->bootstrap();

// use App\Models\PelangganModel;
// use App\Models\TranModel;
// use App\Models\BarangModel;
// use Carbon\Carbon;

// try {
    // Ambil produk pertama sebagai sampel
    // $produk = BarangModel::first();
    // if (!$produk) {
    //     echo "ERROR: Tidak ada produk di tabel barang\n";
    //     exit(1);
    // }

    // $jumlah = 1;

    // Buat pelanggan uji
    // $pelanggan = PelangganModel::create([
    //     'nama_pelanggan' => 'Test User ' . time(),
    //     'telpon' => '08123456789',
    //     'alamat' => 'Alamat Test',
    // ]);

    // Buat transaksi
    // $transaksi = TranModel::create([
    //     'id_pelanggan' => $pelanggan->id,
    //     'id_produk' => $produk->id_barang,
    //     'jumlah' => $jumlah,
    //     'subtotal' => $produk->harga * $jumlah,
    //     'total' => $produk->harga * $jumlah,
    //     'tanggal' => Carbon::now()->toDateString(),
    // ]);

    // Kurangi stok
//     $produk->decrement('stok', $jumlah);

//     echo "OK\n";
//     echo "Pelanggan:\n" . json_encode($pelanggan->toArray(), JSON_PRETTY_PRINT) . "\n";
//     echo "Transaksi:\n" . json_encode($transaksi->toArray(), JSON_PRETTY_PRINT) . "\n";
//     echo "Sisa stok produk (id {$produk->id_barang}): {$produk->stok}\n";
// } catch (\Exception $e) {
//     echo "EXCEPTION: " . $e->getMessage() . "\n";
//     echo $e->getTraceAsString();
//     exit(1);
// }
