@extends('layout.master')

@section('content')
<div style="padding: 0 20px; width: 100%; margin: 20px;">
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('dashboard-penghuni', ['id' => $property->id]) }}" class="btn-back">
            <i class='bx bx-arrow-back'></i>
        </a>
    </div>

    <div class="main-container">
        <h3>Riwayat Penghuni Kos</h3>

        @if ($tenants->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kamar</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Kontak</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tenants as $tenant)
                <tr>
                    <td>{{ $tenant->nama }}</td>
                    <td>{{ $tenant->room->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($tenant->tanggal)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($tenant->tanggal_keluar)->format('d M Y') }}</td>
                    <td>{{ $tenant->telepon }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert alert-info">Belum ada penyewa yang keluar.</div>
        @endif
    </div>
</div>
@endsection
