@extends('layouts.app')

@section('title', 'Dashboard IKP')

@section('content')
<div class="container">
    <h1>Dashboard Bidang IKP</h1>
    <p>Selamat datang, {{ auth()->user()->name }}</p>
    <p>Bidang Anda: {{ auth()->user()->bidang }}</p>

    <hr>
    <p>Konten khusus untuk bidang IKP bisa kamu letakkan di sini.</p>
</div>
@endsection
