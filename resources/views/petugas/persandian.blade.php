@extends('layouts.app')

@section('title', 'Dashboard Persandian')

@section('content')
<div class="container">
    <h1>Dashboard Bidang Persandian</h1>
    <p>Selamat datang, {{ auth()->user()->name }}</p>
    <p>Bidang Anda: {{ auth()->user()->bidang }}</p>

    <hr>
    <p>Konten khusus untuk bidang Persandian bisa kamu letakkan di sini.</p>
</div>
@endsection
