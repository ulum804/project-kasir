<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\TranModel;
use App\Models\PelangganModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Translation\Extractor\Visitor\TransMethodVisitor;

class TranController extends Controller
{
    /**
     * Halaman transaksi (menampilkan barang)
     */
    public function index()
    {
        $transaksi = TranModel::with(['produk', 'pelanggan'])
            ->orderBy('tanggal', 'desc')
            ->get();
        // ambil semua barang agar muncul di tabel transaksi
        $barang = BarangModel::all();
        $keranjang = session()->get('keranjang', []);
        $id_transaksi = session('id_transaksi');

        return view('kasir.transak', ['barang' => BarangModel::all(), 'id_transaksi' => session('id_transaksi')]);
    }

    /**
     * Simpan transaksi
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required',
            'id_produk'    => 'required',
            'jumlah'       => 'required|integer|min:1',
        ]);

        $produk = BarangModel::findOrFail($request->id_produk);

        // Cek stok cukup
        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }

        // hitung subtotal & total
        $subtotal = $produk->harga * $request->jumlah;
        $total    = $subtotal;

        // Simpan transaksi secara atomik
        DB::beginTransaction();
        try {
            TranModel::create([
                'id_pelanggan' => $request->id_pelanggan,
                'id_produk'    => $produk->id_barang,
                'jumlah'       => $request->jumlah,
                'subtotal'     => $subtotal,
                'total'        => $total,
                'tanggal'      => Carbon::now()->toDateString(),
            ]);

            // kurangi stok barang
            $produk->decrement('stok', $request->jumlah);

            DB::commit();
            return redirect()->back()->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi');
        }
    }
    // TAMBAH KE KERANJANG
    public function tambahKeranjang(Request $request)
    {
        $barang = BarangModel::findOrFail($request->id_produk);
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$barang->id_barang])) {
            $keranjang[$barang->id_barang]['jumlah'] += $request->jumlah;
            $keranjang[$barang->id_barang]['subtotal'] =
                $keranjang[$barang->id_barang]['jumlah'] * $barang->harga;
        } else {
            $keranjang[$barang->id_barang] = [
                'id_barang' => $barang->id_barang,
                'nama' => $barang->nama_barang,
                'harga' => $barang->harga,
                'jumlah' => $request->jumlah,
                'subtotal' => $barang->harga * $request->jumlah
            ];
        }

        session()->put('keranjang', $keranjang);
        return back();
    }
    // HAPUS ITEM
    public function hapusKeranjang($id)
    {
        $keranjang = session()->get('keranjang');
        unset($keranjang[$id]);
        session()->put('keranjang', $keranjang);

        return back();
    }
    // SIMPAN TRANSAKSI
    public function simpan(Request $request)
    {
        // 1️⃣ VALIDASI
        $request->validate([
            'produk' => 'required|array|min:1',
            'produk.*.id_produk' => 'required',
            'produk.*.jumlah' => 'required|integer|min:1',
            'produk.*.subtotal' => 'required|integer',
        ]);

        // 2️⃣ CEK STOK SEBELUM MENYIMPAN
        foreach ($request->produk as $item) {
            $barang = BarangModel::find($item['id_produk']);
            if (!$barang || $barang->stok < $item['jumlah']) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk ' . ($barang->nama_barang ?? 'produk'));
            }
        }

        // 3️⃣ SIMPAN PELANGGAN
        $pelanggan = PelangganModel::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat'         => $request->alamat ?? '-',
            'telpon'         => $request->telepon ?? '-',
        ]);

        // 4️⃣ BUAT SATU KODE TRANSAKSI (🔥 DI SINI 🔥)
        $kodeTransaksi = 'TRX-' . date('YmdHis');

        $total = (int) $request->total;

        // 5️⃣ SIMPAN SEMUA PRODUK DENGAN KODE YANG SAMA DAN KURANGI STOK
        DB::beginTransaction();
        try {
            foreach ($request->produk as $item) {
                TranModel::create([
                    'kode_transaksi' => $kodeTransaksi,
                    'id_pelanggan'   => $pelanggan->id,
                    'id_produk'      => $item['id_produk'],
                    'jumlah'         => $item['jumlah'],
                    'subtotal'       => $item['subtotal'],
                    'total'          => $total,
                    'tanggal'        => $request->tanggal,
                ]);

                // Kurangi stok barang
                BarangModel::where('id_barang', $item['id_produk'])
                    ->decrement('stok', $item['jumlah']);
            }

            DB::commit();

            // 6️⃣ SIMPAN KODE KE SESSION (UNTUK DOWNLOAD STRUK)
            session(['kode_transaksi' => $kodeTransaksi]);

            return redirect('/tran')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        }
        //      // validasi dasar
        //    $request->validate([
        //         'produk' => 'required|array|min:1',
        //         'produk.*.id_produk' => 'required',
        //         'produk.*.jumlah' => 'required|integer|min:1',
        //         'produk.*.subtotal' => 'required|integer',
        //     ]);
        //     // simpan pelanggan (contoh)
        //     $pelanggan = PelangganModel::create([
        //         'nama_pelanggan' => $request->nama_pelanggan,
        //         'alamat'         => $request->alamat ?? '-',
        //         'telpon'        => $request->telepon ?? '-',
        //     ]);
        //     $total = (int) $request->total;
        //     // 🔥 INI TEMPAT FOREACH-NYA
        //     // $idTransaksiTerakhir = null;

        //      foreach ($request->produk as $item) {
        //     TranModel::create([
        //         'kode_transaksi' => $kodeTransaksi,
        //         'id_pelanggan'   => $pelanggan->id,
        //         'id_produk'      => $item['id_produk'],
        //         'jumlah'         => $item['jumlah'],
        //         'subtotal'       => $item['subtotal'],
        //         'total'          => $total,
        //         'tanggal'        => $request->tanggal,
        //     ]);
        // }

        //         // DB::commit();

        //         // 🔥 SIMPAN SESSION SETELAH LOOP
        //         session(['kode_transaksi' => $kodeTransaksi]);

        //         return redirect('/tran')->with('success', 'Transaksi berhasil disimpan');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return back()->with('error', 'Gagal menyimpan transaksi');
        // }

        // foreach ($request->produk as $item) {
        //     $tranksaksi = TranModel::create([
        //         'id_pelanggan' => $pelanggan->id,
        //         'id_produk'    => $item['id_produk'],
        //         'jumlah'       => $item['jumlah'],
        //         'subtotal'     => $item['subtotal'],
        //         'total'        => $total,
        //         'tanggal'      => $request->tanggal,
        //     ]);

        //     // simpan ID transaksi terakhir
        //     $idTransaksiTerakhir = $tranksaksi->id_tranksaksi;
        // }
        // // simpan ke session SETELAH foreach - gunakan flash agar persist untuk satu request
        // session()->flash('id_transaksi', $idTransaksiTerakhir);

        // return redirect('/tran')->with('success', 'Transaksi berhasil disimpan');
    }
}
