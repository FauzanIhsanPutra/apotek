@extends('layouts.template')

@section('content')
    <div class="jumbotron py-4 px-5">
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        
        <!-- Welcome Card -->
        <div class="card" style="width: 100%; border: 1px solid #ddd;">
            <div class="card-body">
                <h1 class="display-4">
                    Selamat Datang {{ Auth::user()->name }}!
                </h1>
                <hr style="border: 1px solid #000; width: 100%; margin: 20px auto;">
                <p>
                    Anda telah berhasil login ke dalam sistem. Anda dapat melakukan berbagai hal seperti menambahkan data
                    Obat, menambahkan pembelian, dan lain-lain.
                </p>
            </div>
        </div>
    </div>
@endsection
