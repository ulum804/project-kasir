<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Pembelian</title>
    <style>
        body { font-family: monospace; font-size: 12px; }
        .center { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 4px; }
        .total { border-top: 1px dashed #000; font-weight: bold; }
    </style>
</head>
<body>

<div class="center">
    <h3>STRUK PEMBELIAN</h3>
    <p>{{ $tanggal }}</p>
    <hr>
</div>

<p>
    Pelanggan: {{ $transaksi[0]->nama_pelanggan }} <br>
    No Transaksi: {{ $transaksi[0]->id_tranksaksi }}
</p>

<table>
    @php $grandTotal = 0; @endphp
    @foreach ($transaksi as $item)
        <tr>
            <td>{{ $item->nama_barang }}</td>
            <td class="center">{{ $item->jumlah }} x</td>
            <td class="center">Rp {{ number_format($item->harga,0,',','.') }}</td>
        </tr>
        @php $grandTotal += $item->subtotal; @endphp
    @endforeach
    <tr class="total">
        <td colspan="2">TOTAL</td>
        <td class="center">Rp {{ number_format($grandTotal,0,',','.') }}</td>
    </tr>
</table>

<p class="center">
    Terima kasih 🙏
</p>

</body>
</html>
