@extends('layouts.template')

@section('content')
    <div class="container mt-3">
        <div class="text-center">
            <h1>Riwayat Pembelian</h1>
        </div>
        
        {{-- <form action="{{ route('kasir.order.index') }}" method="GET" class="d-flex justify-content-end mb-3">
            <input type="date" name="search_date" class="form-control me-2" placeholder="Cari berdasarkan tanggal" value="{{ request('search_date') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form> --}}

        <div class="d-flex justify-content-end">
            <a href="{{ route('order.export-excel') }}" class="btn btn-warning">Export Data(Excel)</a>
        </div>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Pembeli</th>
                    <th>Obat</th>
                    <th>Total Bayar</th>
                    <th>Kasir</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($orders as $item)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $item->name_customer }}</td> <!-- Corrected here -->
                        <td>
                            @if ($item->medicines && is_array($item->medicines))
                                @foreach ($item->medicines as $medicine)
                                    @php
                                        $price = isset($medicine['price']) ? (int) $medicine['price'] : 0;
                                    @endphp
                                    <p>{{ $loop->iteration }}. {{ $medicine['name_medicine'] ?? 'Nama obat tidak tersedia' }} 
                                        ({{ number_format($price, 0, ',', '.') }})</p>
                                @endforeach
                            @else
                                <p>Tidak ada data obat</p>
                            @endif
                        </td>
                        <td>Rp. {{ number_format($item->total_price, 0, ',', '.') }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>            
        </table>

        <div class="d-flex justify-content-end">
            {{-- @if ($orders->count())
                <div class="pagination-wrapper">
                    {{ $orders->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif --}}
        </div>
    </div>
@endsection
