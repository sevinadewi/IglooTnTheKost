{{-- <h2>Halo {{ $tenant->nama }},</h2>
<p>Ini adalah pengingat bahwa pembayaran kos Anda sebesar <strong>Rp {{ number_format($tenant->harga) }}</strong> akan jatuh tempo pada tanggal <strong>{{ \Carbon\Carbon::parse($tenant->tanggal)->format('d') }}</strong> bulan ini.</p>
<p>Silakan lakukan pembayaran sebelum tanggal tersebut.</p>
<p>Terima kasih!</p> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .email-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .email-header img {
            max-height: 60px;
        }

        .email-content h2 {
            color: #000;
            font-size: 22px;
        }

        .email-content p {
            font-size: 16px;
            line-height: 1.6;
        }

        .highlight {
            color: #EBC005;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            font-size: 13px;
            text-align: center;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('assets/img/IndekostLogo.svg'))) }}" alt="Minkos Logo">

        </div>

        <div class="email-content">
            <h2>Halo {{ $tenant->nama }},</h2>
            <p>
                Ini adalah pengingat bahwa pembayaran kos Anda sebesar
                <span class="highlight">Rp {{ number_format($tenant->harga) }}</span>
                akan jatuh tempo pada tanggal
                <span class="highlight">{{ \Carbon\Carbon::parse($tenant->tanggal)->format('d') }}</span>
                bulan ini.
            </p>
            <p>Silakan lakukan pembayaran sebelum tanggal tersebut.</p>
            <p>Terima kasih telah menjadi bagian dari <strong>Minkos</strong>!</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Minkos. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>


