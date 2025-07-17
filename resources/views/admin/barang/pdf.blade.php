<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        h1, h2, h3 {
            text-align: center;
            margin: 0;
        }

        .sub-header {
            margin-top: 10px;
            text-align: center;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
        }

        th {
            background-color: #eee;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>
<body>

    <h2>BUKU INVENTARIS GABUNGAN</h2>
    <h3>DINAS KOMUNIKASI DAN INFORMATIKA</h3>
    <p class="sub-header">
        Provinsi: KALIMANTAN SELATAN<br>
        Kabupaten/Kota: BARITO KUALA
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kode</th>
                <th>Merk / Type</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Sumber</th>
                <th>Status</th>
                <th>Keterangan<
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barangs as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->merk_type ?? '-' }}</td>
                    <td>{{ $barang->satuan }}</td>
                    <td>{{ $barang->jumlah }}</td>
                    <td>{{ $barang->stok }}</td>
                    <td>Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                    <td>{{ $barang->sumber_barang }}</td>
                    <td>
                        {{ $barang->stok > 0 ? 'Tersedia' : 'Habis' }}
                    </td>
                    <td class="text-left">{{ $barang->keterangan ?? '-' }}</td>
                    <td>
                        @if ($barang->gambar)
                            <img src="{{ public_path('storage/' . $barang->gambar) }}" width="40" height="40" style="object-fit: cover;">
                        @else
                            -
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="11">Tidak ada data barang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
