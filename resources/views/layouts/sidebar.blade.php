@if(Auth::user()->hasRole('admin'))
    <li><a href="{{ route('kategori.index') }}">Kategori</a></li>
    <li><a href="{{ route('bidang.index') }}">Bidang</a></li>
    <li><a href="{{ route('barang.index') }}">Data Barang</a></li>
    <li><a href="{{ route('barang.masuk') }}">Barang Masuk</a></li>
    <li><a href="{{ route('barang.keluar') }}">Barang Keluar</a></li>
    <li><a href="{{ route('peminjaman.index') }}">Peminjaman</a></li>
    <li><a href="{{ route('aduan.index') }}">Aduan Barang</a></li>
    <li><a href="{{ route('laporan.index') }}">Laporan</a></li>
@endif
