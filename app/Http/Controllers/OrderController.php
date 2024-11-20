<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{



    public function index(Request $request)
    {
        $orders = Order::with('user')->simplePaginate(5); // Tetap dengan user sebagai relasi
        return view('order.kasir.index', compact('orders'));
    }

    public function create () {
    $medicines = Medicine::all();
    return view("order.kasir.create", compact('medicines'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',
            'medicines' => 'required',

        ]);

        // Mencari jumlah values yang sama pada array
        $arrayDistinct = array_count_values($request->medicines);
        $arrayAssocMedicines = []; 

        foreach ($arrayDistinct as $id => $count) {
            $medicine = Medicine::find($id);

            if (!$medicine) {
                return redirect()->back()->with('failed', "Obat dengan ID {$id} tidak ditemukan");
            }

            if ($medicine->stock < $count) {
                $msg = "Obat " . $medicine->name . " sisa stok: " . $medicine->stock . ". Tidak dapat melakukan pembelian.";
                return redirect()->back()->withInput()->with('failed', $msg);
            }

            // Update stok
            $medicine->stock -= $count;
            $medicine->save();

            // Tambahkan ke array
            $arrayItem = [
                "id" => $id,
                "name_medicine" => $medicine['name'], // Nama obat
                "qty" => $count,                      // Jumlah beli
                "price" => $medicine['price'],        // Harga satuan
                "sub_price" => $count * $medicine['price'], // Total harga per item
            ];

            $arrayAssocMedicines[] = $arrayItem;
        }


        // Hitung total harga
        $priceWithPPN = array_sum(array_column($arrayAssocMedicines, 'sub_price'));

        // Simpan data order
        $order = Order::create([
            'user_id' => Auth::id(),
            'medicines' => $arrayAssocMedicines, // Cast automatically to JSON
            'name_customer' => $request->name_customer, // Ensure it's here
            'total_price' => $priceWithPPN,
        ]);    

        if ($order) {
            return redirect()->route('kasir.order.index')->with('success', 'Pembelian berhasil dibuat');
        } else {
            return redirect()->back()->with('failed', 'Gagal membuat data pembelian');
        }
    }

        public function show($id)
        {
            $order = Order::find($id);
            return view('order.kasir.print', compact('order'));
        }

        public function downloadPDF($id) {
            $order = Order::find($id)->toArray();
            view()->share('order', $order);
            $pdf = PDF::loadView('order.kasir.download', $order);
            return $pdf->download('receipt.pdf');
        }
        public function data()
        {
            $orders = Order::with('user')->simplePaginate(5);
            return view('order.admin.index', compact('orders'));
        }

        public function exportExcel()
        {
            $file_name = 'data_pembelian'.'.xlsx';

            return Excel::download(new OrderExport, $file_name);
        }

}