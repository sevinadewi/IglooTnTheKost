@extends('layout.master')

@section('styles')
    <style>
        .form-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: auto;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
        }

        .form-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-row .form-group {
            flex: 1;
            min-width: 200px;
        }

        .image-preview img {
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .form-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-save {
            background-color: #fcd92c;
            color: #333;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-save:hover {
            background-color: #d4b51b;
        }

        .btn-cancel {
            background-color: #ccc;
            color: #333;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-cancel:hover {
            background-color: #aaa;
        }

    </style>
@endsection


@section('content')
<div class="main-content">
    <h2>Edit Properti</h2>

    <form action="{{ route('property.update', $property->id) }}" method="POST" enctype="multipart/form-data" class="form-card">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Properti</label>
            <input type="text" name="nama" value="{{ old('nama', $property->nama) }}" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="{{ old('alamat', $property->alamat) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Kode Pos</label>
                <input type="text" name="kode_pos" value="{{ old('kode_pos', $property->kode_pos) }}" required>
            </div>

            <div class="form-group">
                <label>Provinsi</label>
                <input type="text" name="provinsi" value="{{ old('provinsi', $property->provinsi) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Kota/Kabupaten</label>
                <input type="text" name="kota_kabupaten" value="{{ old('kota_kabupaten', $property->kota_kabupaten) }}" required>
            </div>

            <div class="form-group">
                <label>Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan', $property->kecamatan) }}" required>
            </div>

            <div class="form-group">
                <label>Kelurahan</label>
                <input type="text" name="kelurahan" value="{{ old('kelurahan', $property->kelurahan) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Nomor WhatsApp</label>
            <input type="text" name="no_wa" value="{{ old('no_wa', $property->no_wa) }}">
        </div>

        <div class="form-group">
            <label>Foto Properti</label>
            <input type="file" name="foto" accept="image/*">
            @if ($property->foto)
                <div class="image-preview">
                    <img src="{{ asset($property->foto) }}" alt="Foto Properti" width="120">
                </div>
            @endif
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-save">Simpan Perubahan</button>
            <a href="{{ route('property.setting', ['id' => $property->id]) }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>

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


