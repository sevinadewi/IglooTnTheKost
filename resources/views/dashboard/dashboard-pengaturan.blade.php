@extends('layout.master')
@section('styles')
    <style>
        .card-label {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: white;
            padding: 0 15px 10px;
        }

        .card-header {
            font-size: 40px;
            text-align: center;
            padding: 20px 0 10px;
        }

        .btn-action {
            background-color: #fff;
            color: #333;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
        }

        .btn-action:hover {
            background-color: #f5f5f5;
        }

        .btn-action.danger {
            color: #d33;
        }

        .btn-action.danger:hover {
            background-color: #f9d6d6;
        }

    </style>
    
@endsection

@section('content')
<div class="main-content">
    <h2>Pengaturan Properti</h2>

    <div class="card-container">
        <!-- Card Edit -->
        <div class="card yellow">
            <div class="card-header">
                <i class='bx bx-edit'></i>
            </div>
            <div class="card-label">
                <span>Edit Properti</span>
            </div>
            <div class="card-footer">
                <a href="{{ route('property.edit', $property->id) }}" class="btn-action">Edit</a>
            </div>
        </div>

        <!-- Card Hapus -->
        <div class="card red">
            <div class="card-header">
                <i class='bx bx-trash'></i>
            </div>
            <div class="card-label">
                <span>Hapus Properti</span>
            </div>
            <div class="card-footer">
                <form action="{{ route('property.destroy', $property->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Yakin ingin menghapus properti ini?',
            text: "Semua data kamar dan penghuni akan ikut terhapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }
</script>
@endsection
