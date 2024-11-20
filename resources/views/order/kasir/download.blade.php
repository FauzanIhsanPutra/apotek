<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
            flex-direction: column;
        }
        #back-wrap {
            margin: 30px auto;
            width: 500px;
            display: flex;
            justify-content: flex-end;
        }
        .btn-back {
            width: fit-content;
            padding: 8px 15px;
            color: #fff;
            background: #666;
            border-radius: 5px;
            text-decoration: none;
        }
        #receipt {
            box-shadow: 5px 10px 15px rgba(0, 0, 0, 0.5);
            padding: 20px;
            width: 500px;
            background: #fff;
            margin: 0 auto;
        }
        h2 {
            font-size: .9rem;
        }
        p {
            font-size: .8rem;
            color: #666;
            line-height: 1.2rem;
        }
        #top {
            margin-top: 25px;
        }
        #top .info {
            text-align: left;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 5px 0 5px 15px;
            border: 1px solid #eee;
        }
        .tabletitle {
            font-size: .5rem;
            background: #eee;
        }
        .service {
            border-bottom: 1px solid #eee;
        }
        .itemtext {
            font-size: .7rem;
        }
        #legalcopy {
            margin-top: 15px;
            text-align: center;
        }
        .btn-print {
            float: right;
            color: #333;
        }

        p {
            font-size: .8rem;
            color: #666;
            line-height: 1.2rem;
            text-align: center;
        }

        #legalcopy {
            margin-top: 15px;
        }

        .tabletitle {
            font-size: .5rem;
            background: #eee;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="back-wrap">
        {{-- <a href="{{ route('kasir.order.index') }}" class="btn-back">Kembali</a> --}}
    </div>
    <div id="receipt">
        {{-- <a href="{{ route('kasir.order.download', $order['id']) }}" class="btn-print">Cetak (.pdf)</a> --}}
        <center id="top">
            <div class="info">
                <h1>Apotek Jaya Abadi</h1>
            </div>
        </center>
        <div id="id">
            <div class="info">
                <p>
                    Alamat : Sepanjang jalan kenangan<br>
                    Email : aptekjayaabadi@gmail.com<br>
                    Phone : 000-111-2222<br>
                </p>
            </div>
        </div>
        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item">
                            <h2>Obat</h2>
                        </td>
                        <td class="item">
                            Total
                        </td>
                        <td class="item">
                            Harga
                        </td>
                    </tr>
                    @foreach (is_array($order['medicines']) ? $order['medicines'] : json_decode($order['medicines'], true) as $medicine)
                    <tr class="service">
                        <td class="tableitem">
                            <p class="itemtext">{{ $medicine['name_medicine'] }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext">{{ $medicine['qty'] }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext">
                                @if (isset($medicine['price']))
                                    Rp. {{ number_format($medicine['price'], 0, ',', '.') }}
                                @else
                                    <em>Harga tidak tersedia</em>
                                @endif
                            </p>
                        </td>
                    </tr>    
                    @endforeach
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>PPN (10%)</h2>
                        </td>
                        @php
                            $ppn = $order['total_price'] * 0.1; // Calculate the 10% PPN
                        @endphp
                        <td class="payment">
                            <h2>Rp. {{ number_format($ppn, 0, ',', '.') }}</h2>
                        </td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>Total Harga</h2>
                        </td>
                        @php
                            $totalWithPpn = $order['total_price'] + $ppn; // Add PPN to the original total price
                        @endphp
                        <td class="payment">
                            <h2>Rp. {{ number_format($totalWithPpn, 0, ',', '.') }}</h2> <!-- Display the final total -->
                        </td>
                    </tr>
                </table>
            </div>
            <div id="legalcopy">
                <p class="legal"><strong>Terima kasih atas pembelian anda</strong><br>
                    Apabila ada keluhan atau pertanyaan, silakan hubungi Customer Service kami.<br>
                    Jika tidak diberikan struk oleh kasir, maka pembelian anda gratis!!
                </p>
            </div>
        </div>
    </div>
</body>
</html>