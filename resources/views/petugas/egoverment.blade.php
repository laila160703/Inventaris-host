@extends('layouts.app')

@section('title', 'Dashboard E-Government')

@section('content')
<div class="container">
    <h1>Dashboard Bidang E-Government (Egov)</h1>
    <p>Selamat datang, {{ auth()->user()->name }}</p>
    <p>Bidang Anda: {{ auth()->user()->bidang }}</p>

    <hr>
    <p>Konten khusus untuk bidang E-Government bisa kamu letakkan di sini.</p>
</div>
@endsection
