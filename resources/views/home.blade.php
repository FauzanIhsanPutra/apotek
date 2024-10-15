@extends('layouts.template')

@section('content')
<div class="jumbotron py-4 px-5">
    <h1 class="display-4">
        selamat datang {{ Auth::user()->name}}!
    </h1>
    <hr class="my-4">
    <p>Aplikasi ini digunakan hanya oleh pegawai administator APOTEK. Digunakan untuk mengelola data obat, penyetokan, juga (kasir).</p>
</div>
@endsection