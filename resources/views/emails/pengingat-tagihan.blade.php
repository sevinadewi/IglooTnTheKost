<h2>Halo {{ $tenant->nama }},</h2>
<p>Ini adalah pengingat bahwa pembayaran kos Anda sebesar <strong>Rp {{ number_format($tenant->harga) }}</strong> akan jatuh tempo pada tanggal <strong>{{ \Carbon\Carbon::parse($tenant->tanggal)->format('d') }}</strong> bulan ini.</p>
<p>Silakan lakukan pembayaran sebelum tanggal tersebut.</p>
<p>Terima kasih!</p>
