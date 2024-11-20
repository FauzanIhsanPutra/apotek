<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Excel;
use App\Exports\OrdersExport;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Mengambil data pesanan beserta informasi pengguna terkait
        return Order::with('user')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Menentukan judul kolom pada file Excel
        return [
            'Nama Pembeli',
            'Obat',
            'Total Bayar',
            'Kasir',
            'Tanggal',
        ];
    }
    public function map($item): array
{
    // Inisialisasi variabel untuk menyimpan data obat dalam format string
    $dataObat = '';

    // Iterasi melalui koleksi obat dari item (mungkin array atau collection)
    foreach ($item->medicines as $value) {
        // Membentuk string untuk setiap obat dengan format:
        // Nama Obat (qty Jumlah Rp. Harga),
        $format = $value['name_medicine'] . ' (qty ' . $value['qty'] . ' Rp. ' . number_format($value['sub_price']) . '),';

        // Menambahkan string yang terbentuk ke variabel $dataObat
        $dataObat .= $format;
    }

    // Mengembalikan array yang berisi data yang akan ditampilkan di Excel
    return [
        $item->name_customer, // Nama pelanggan
        $dataObat, // Data obat dalam format string
        $item->total_price, // Total harga
        $item->user->name, // Nama pengguna
        \Carbon\Carbon::parse($item->created_at)->isoFormat($item->created_at), // Tanggal pembuatan dalam format ISO
    ];
}
}
