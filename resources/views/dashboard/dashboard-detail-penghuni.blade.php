@extends('layout.master')

@section('styles')
    <style>
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 15px 100px; /* padding bawah besar agar tidak potong */
            font-family: Arial, sans-serif;
            color: #333;
            min-height: calc(100vh - 60px); /* agar container selalu setinggi viewport */
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 1.8rem;
            color: #444;
        }

        .box {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }

        .box:hover {
            transform: translateY(-2px);
        }

        .box h3 {
            margin-bottom: 15px;
            font-size: 1.4rem;
            color: #222;
            border-bottom: 2px solid #fcd92c;
            display: inline-block;
            padding-bottom: 4px;
        }

        .detail-box p {
            margin: 8px 0;
            font-size: 0.95rem;
        }

        .detail-box p strong {
            color: #555;
            width: 120px;
            display: inline-block;
        }

        /* Tombol kembali */
        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: #fcd92c;
            color: #000;
            border-radius: 50%;
            text-decoration: none;
            font-size: 1.2rem;
            margin-bottom: 10px;
            transition: background-color 0.2s;
        }

        .btn-back:hover {
            background: #e1be26;
        }

        .payment-box {
            max-height: 300px;      /* tingginya fix, supaya kalau data panjang bisa scroll */
            overflow-y: auto;       /* scroll vertical kalau melebihi max-height */
            overflow-x: auto;       /* scroll horizontal kalau tabel lebar */
            margin-bottom: 80px;    /* jarak bawah supaya tidak potong di layar */
            padding-bottom: 5px;    /* tambahan kecil supaya scroll bar tidak ketutup */
            box-sizing: border-box;
        }


        .payment-box table {
            width: 100%;
            min-width: 500px; /* supaya scroll horizontal muncul di layar sempit */
            border-collapse: collapse;
            font-size: 0.93rem;
        }

        .payment-box thead tr {
            background-color: #fcd92c;
        }

        .payment-box th, .payment-box td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }

        .payment-box tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .payment-box tbody tr:hover {
            background-color: #f5f5f5;
        }
        /* Scrollbar khusus untuk webkit browser (Chrome, Edge, Safari) */
        .payment-box::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .payment-box::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .payment-box::-webkit-scrollbar-thumb {
            background: #c8c8c8;
            border-radius: 4px;
        }

        .payment-box::-webkit-scrollbar-thumb:hover {
            background: #a6a6a6;
        }

        /* Scrollbar di Firefox (lebih terbatas) */
        .payment-box {
            scrollbar-width: thin;
            scrollbar-color: #c8c8c8 #f1f1f1;
        }



        /* Responsive di layar kecil */
        @media (max-width: 600px) {
            .box {
                padding: 15px 18px;
            }
            .box h3 {
                font-size: 1.2rem;
            }
            .detail-box p {
                font-size: 0.9rem;
            }
            .payment-box table, .payment-box th, .payment-box td {
                font-size: 0.85rem;
            }
        }
        </style>
@endsection
@section('content')
<div class="container">
    <a href="{{ route('dashboard-penghuni', ['id' => $property->id]) }}" class="btn-back">
            <i class='bx bx-arrow-back'></i>
        </a>
    

    <div class="box detail-box">
        <h3>Detail Penyewa</h3>
        <p><strong>Nama:</strong> {{ $tenant->nama }}</p>
        <p><strong>Telepon:</strong> {{ $tenant->telepon }}</p>
        <p><strong>Email:</strong> {{ $tenant->email ?? '-' }}</p>
        <p><strong>Tanggal Masuk:</strong> {{ \Carbon\Carbon::parse($tenant->tanggal)->format('d-m-Y') }}</p>
        <p><strong>Nama Kamar:</strong> {{ $tenant->room->nama ?? '-' }}</p>
        <p><strong>Harga Sewa:</strong> Rp{{ number_format($tenant->harga,0,',','.') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($tenant->status) }}</p>
    </div>

    <div class="box payment-box">
        <h3>Status Pembayaran</h3>
        @if ($tenant->bills && count($tenant->bills))
            <table>
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenant->bills as $bill)
                        <tr>
                            <td>{{ $bill->bulan }}</td>
                            <td>{{ $bill->tahun }}</td>
                            <td>Rp{{ number_format($bill->jumlah,0,',','.') }}</td>
                            <td>{{ ucfirst($bill->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Belum ada data tagihan.</p>
        @endif
    </div>
</div>
@endsection