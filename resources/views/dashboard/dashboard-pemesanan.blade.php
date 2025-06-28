@extends('layout.master')

@section('content')
<div class="main-container">
    <h2>Daftar Pemesanan Kamar - {{ $property->nama }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button onclick="showForm('reservationModal')" class="btn-add">+ Tambah Pemesanan</button>

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Kamar</th>
                <th>Harga</th>
                <th>Tanggal Masuk</th>
                <th>Catatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->nama }}</td>
                <td>{{ $reservation->telepon }}</td>
                <td>{{ $reservation->email }}</td>
                <td>{{ $reservation->room->nama_kamar ?? '-' }}</td>
                <td>
                    Rp {{ number_format($reservation->room->harga ?? 0) }}
                </td>
                <td>{{ \Carbon\Carbon::parse($reservation->tanggal_masuk)->format('d-m-Y') }}</td>
                <td>{{ $reservation->catatan }}</td>
                <td>
                    @if($reservation->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($reservation->status == 'booked')
                        <span class="badge bg-success">Booked</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </td>
                <td>
                    @if($reservation->status == 'pending')
                        <form action="{{ route('reservations.accept', $reservation->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-sm btn-primary" onclick="return confirm('Terima pemesanan ini?')">Accept</button>
                        </form>

                        <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Batalkan pemesanan ini?')">Cancel</button>
                        </form>
                    @else
                        <em>Tidak ada aksi</em>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="reservationModal" class="modal">
        <div class="modal-content">
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <h3 id="formTitle">Tambah Pemesanan</h3>

                <input type="hidden" name="property_id" value="{{ $property->id }}">

                <input type="text" id="nama" name="nama" placeholder="Nama" required>
                <input type="text" id="telepon" name="telepon" placeholder="No. Telepon" required>
                <input type="email" id="email" name="email" placeholder="Email">

                <label for="tanggal_masuk">Tanggal Masuk</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk" required>

                <select name="room_id" id="roomSelect" required>
                    <option value="">Pilih Kamar</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" data-harga="{{ $room->harga }}">
                            {{ $room->nama }} - Rp {{ number_format($room->harga) }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="harga_display" id="hargaField" placeholder="Harga" readonly required>

                <textarea name="catatan" placeholder="Catatan (Opsional)"></textarea>

                <div class="form-buttons">
                    <button type="submit" class="btn-save">Simpan</button>
                    <button type="button" onclick="hideForm('reservationModal')" class="btn-cancel">Batal</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    const roomSelect = document.getElementById('roomSelect');
    const hargaField = document.getElementById('hargaField');

    roomSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const harga = selectedOption.getAttribute('data-harga') || '';
        hargaField.value = harga;
    });

    function showForm(id) {
        document.getElementById(id).style.display = 'block';
    }

    function hideForm(id) {
        document.getElementById(id).style.display = 'none';
    }
</script>

{{-- NOTIFIKASI SUCCESS --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif

{{-- NOTIFIKASI ERROR --}}
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        showConfirmButton: true
    });
</script>
@endif

@endsection
