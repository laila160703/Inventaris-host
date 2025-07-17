@extends('layouts.app')

@section('title', 'Dashboard Kesekretariatan')

@section('content')
<div class="container">
    <h1>Dashboard Bidang Kesekretariatan</h1>
    <p>Selamat datang, {{ auth()->user()->name }}</p>
    <p>Bidang Anda: {{ auth()->user()->bidang }}</p>

    <hr>
    <p>Konten khusus untuk bidang Kesekretariatan bisa kamu letakkan di sini.</p>
</div>
@endsection
