@extends('layouts.admin')

@section('title', 'Laporan Barang')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<style>
    .dt-button {
        margin-right: 8px;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    @media print {
        .dt-buttons,
        .no-print,
        nav,
        .sidebar,
        .dark\:bg-gray-900 {
            display: none !important;
        }

        #print-header {
            display: block !important;
        }

        body {
            color: #000 !important;
            background-color: #fff !important;
            font-family: 'Times New Roman', Times, serif;
        }

        table {
            page-break-inside: avoid;
        }

        th, td {
            color: #000 !important;
        }
    }
</style>
@endpush

@section('content')
<div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">📋 Laporan Barang</h2>

    {{-- Header Cetak --}}
    <div id="print-header" class="hidden print:block mb-6 text-center border-b pb-4">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="mx-auto mb-2" style="height: 80px;">
        <h1 class="text-xl font-bold uppercase">Dinas Komunikasi dan Informatika</h1>
        <p class="text-sm">Kabupaten Barito Kuala, Kalimantan Selatan</p>

        @if(request('bulan_masuk') || request('tahun_masuk'))
        <h2 class="mt-4 text-lg font-semibold underline">
            Laporan Barang Masuk Bulan 
            {{ request('bulan_masuk') ? \Carbon\Carbon::createFromDate(null, (int) request('bulan_masuk'), 1)->translatedFormat('F') : 'Semua' }}
            Tahun {{ request('tahun_masuk') ?? 'Semua' }}
        </h2>
        @endif

        @if(request('bulan_keluar') || request('tahun_keluar'))
        <h2 class="mt-2 text-lg font-semibold underline">
            Laporan Barang Keluar Bulan 
            {{ request('bulan_keluar') ? \Carbon\Carbon::createFromDate(null, (int) request('bulan_keluar'), 1)->translatedFormat('F') : 'Semua' }}
            Tahun {{ request('tahun_keluar') ?? 'Semua' }}
        </h2>
        @endif
    </div>

    {{-- Filter Panel --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 no-print">
        {{-- Barang Masuk --}}
        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl shadow">
            <h3 class="font-bold text-lg text-gray-700 dark:text-white mb-2">📥 Laporan Barang Masuk</h3>
            <form action="{{ route('admin.laporan.laporan') }}" method="GET" class="space-y-2">
                <div class="flex gap-2">
                    <select name="bulan_masuk" class="w-full px-3 py-2 rounded border dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan_masuk') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="tahun_masuk" class="w-full px-3 py-2 rounded border dark:bg-gray-700 dark:text-white">
                        @for ($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('tahun_masuk') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">🔍 Tampilkan</button>
            </form>
        </div>

        {{-- Barang Keluar --}}
        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl shadow">
            <h3 class="font-bold text-lg text-gray-700 dark:text-white mb-2">📤 Laporan Barang Keluar</h3>
            <form action="{{ route('admin.laporan.laporan') }}" method="GET" class="space-y-2">
                <div class="flex gap-2">
                    <select name="bulan_keluar" class="w-full px-3 py-2 rounded border dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan_keluar') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="tahun_keluar" class="w-full px-3 py-2 rounded border dark:bg-gray-700 dark:text-white">
                        @for ($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('tahun_keluar') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded shadow">🔍 Tampilkan</button>
            </form>
        </div>
    </div>

    {{-- Data Barang Masuk --}}
    <div class="bg-white dark:bg-gray-900 p-4 rounded-lg shadow mt-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">📥 Data Barang Masuk</h3>
        <div class="flex justify-end mb-2">
            <label>
                Tampilkan 
                <select id="masukLength" class="border rounded px-2 py-1 mx-1">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="-1">Semua</option>
                </select>
                data
            </label>
        </div>
        <table id="barangMasukTable" class="min-w-full text-sm border border-gray-300">
            <thead class="bg-blue-100 dark:bg-blue-900 text-gray-800 dark:text-white font-semibold">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Kode Transaksi</th>
                    <th class="px-4 py-2 border">Tanggal Masuk</th>
                    <th class="px-4 py-2 border">Kode Barang</th>
                    <th class="px-4 py-2 border">Nama Barang</th>
                    <th class="px-4 py-2 border">Supplier</th>
                    <th class="px-4 py-2 border">Jumlah</th>
                    <th class="px-4 py-2 border">Satuan</th>
                </tr>
            </thead>
            <tbody>
                @php $totalMasuk = 0; @endphp
                @foreach ($barangMasuks as $item)
                    @php $totalMasuk += $item->jumlah; @endphp
                    <tr>
                        <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $item->kode_transaksi }}</td>
                        <td class="px-4 py-2 border">{{ $item->tanggal_masuk }}</td>
                        <td class="px-4 py-2 border">{{ $item->barang->kode_barang }}</td>
                        <td class="px-4 py-2 border">{{ $item->barang->nama_barang }}</td>
                        <td class="border px-4 py-2">{{ $item->supplier ?? '-' }}</td>
                        <td class="px-4 py-2 border text-center">{{ $item->jumlah }}</td>
                        <td class="px-4 py-2 border text-center">{{ $item->barang->satuan }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-blue-200 dark:bg-blue-800 font-semibold text-gray-900 dark:text-white">
                    <td colspan="6" class="text-right px-4 py-2 border">Total Barang Masuk:</td>
                    <td class="text-center px-4 py-2 border">{{ $totalMasuk }}</td>
                    <td class="border"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Data Barang Keluar --}}
    <div class="mt-10 bg-white dark:bg-gray-900 p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">📤 Data Barang Keluar</h3>
        <div class="flex justify-end mb-2">
            <label>
                Tampilkan 
                <select id="keluarLength" class="border rounded px-2 py-1 mx-1">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="-1">Semua</option>
                </select>
                data
            </label>
        </div>
        <table id="barangKeluarTable" class="min-w-full text-sm border border-gray-300">
            <thead class="bg-indigo-100 dark:bg-indigo-900 text-gray-800 dark:text-white font-semibold">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Kode Transaksi</th>
                    <th class="px-4 py-2 border">Tanggal Keluar</th>
                    <th class="px-4 py-2 border">Kode Barang</th>
                    <th class="px-4 py-2 border">Nama Barang</th>
                    <th class="px-4 py-2 border">Penerima</th>
                    <th class="px-4 py-2 border">Jumlah</th>
                    <th class="px-4 py-2 border">Satuan</th>
                </tr>
            </thead>
            <tbody>
                @php $totalKeluar = 0; @endphp
                @foreach ($barangKeluars as $item)
                    @php $totalKeluar += $item->jumlah; @endphp
                    <tr>
                        <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $item->kode_transaksi }}</td>
                        <td class="px-4 py-2 border">{{ $item->tanggal_keluar }}</td>
                        <td class="px-4 py-2 border">{{ $item->barang->kode_barang }}</td>
                        <td class="px-4 py-2 border">{{ $item->barang->nama_barang }}</td>
                        <td class="px-4 py-2 border">{{ $item->bidang->nama ?? '-' }}</td>
                        <td class="px-4 py-2 border text-center">{{ $item->jumlah }}</td>
                        <td class="px-4 py-2 border text-center">{{ $item->barang->satuan }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-indigo-200 dark:bg-indigo-800 font-semibold text-gray-900 dark:text-white">
                    <td colspan="6" class="text-right px-4 py-2 border">Total Barang Keluar:</td>
                    <td class="text-center px-4 py-2 border">{{ $totalKeluar }}</td>
                    <td class="border"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    $(document).ready(function () {
        // Tombol Export Word
        function generateWordButton(filename) {
            return {
                text: '📃 Word',
                className: 'bg-gray-600 text-white px-3 py-1 rounded',
                action: function (e, dt) {
                    const data = dt.buttons.exportData();
                    let content = `
<html>
<head><meta charset='UTF-8'>
<style>
    body { font-family: Arial; font-size: 12px; }
    h2 { text-align: center; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 8px; }
    th { background: #eee; }
</style>
</head>
<body>
<h2>${filename.replace(/_/g, ' ')}</h2>
<table><tr>`;
                    data.header.forEach(h => content += `<th>${h}</th>`);
                    content += "</tr>";
                    data.body.forEach(row => {
                        content += "<tr>";
                        row.forEach(col => content += `<td>${col}</td>`);
                        content += "</tr>";
                    });
                    content += "</table></body></html>";

                    const blob = new Blob(["\ufeff" + content], { type: "application/msword" });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement("a");
                    a.href = url;
                    a.download = filename + ".doc";
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }
            }
        }

        // Konfigurasi DataTable
       const configDataTable = (selector, title, isMasuk = true) => {
        return $(selector).DataTable({
            dom: 'Bfrtip',
            paging: true, // Hapus pagination
            lengthMenu: [ [5, 10, 25, -1], [5, 10, 25, "Semua"] ],
            buttons: [
            
                    {
                        extend: 'excelHtml5',
                        text: '📥 Excel',
                        className: 'bg-green-500 text-white px-3 py-1 rounded mr-2',
                        title: title
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '📄 PDF',
                        className: 'bg-red-500 text-white px-3 py-1 rounded mr-2',
                        title: null,
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function (doc) {
                            doc.styles.tableHeader = {
                                bold: true,
                                fontSize: 12,
                                color: 'black',
                                fillColor: '#dee2e6'
                            };
                            doc.defaultStyle.fontSize = 11;

                            const reportTitle = isMasuk ? 'LAPORAN BARANG MASUK' : 'LAPORAN BARANG KELUAR';

                            doc.content.splice(0, 0, {
                                alignment: 'center',
                                margin: [0, 0, 0, 20],
                                text: [
                                    { text: 'DINAS KOMUNIKASI DAN INFORMATIKA\n', fontSize: 16, bold: true },
                                    { text: 'Kabupaten Barito Kuala, Kalimantan Selatan\n\n', fontSize: 12 },
                                    { text: reportTitle + '\n\n', fontSize: 14, bold: true }
                                ]
                            });
                        }
                    },
                    {
                        extend: 'print',
                        text: '🖨️ Print',
                        className: 'bg-gray-500 text-white px-3 py-1 rounded mr-2',
                        title: title
                    },
                    generateWordButton(title.replace(/\s/g, '_'))
                ]
            });
        };

        // Inisialisasi
        const tableMasuk = configDataTable('#barangMasukTable', 'Laporan Barang Masuk', true);
        const tableKeluar = configDataTable('#barangKeluarTable', 'Laporan Barang Keluar', false);

        // Listener untuk dropdown jumlah data
       $('#masukLength').on('change', function () {
            const value = parseInt($(this).val());
            tableMasuk.page.len(value).draw();
        });

        $('#keluarLength').on('change', function () {
            const value = parseInt($(this).val());
            tableKeluar.page.len(value).draw();
        });

    });
</script>
@endpush
