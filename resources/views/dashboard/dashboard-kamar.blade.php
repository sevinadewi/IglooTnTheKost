@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .btn-icon {
        border: none;
        padding: 6px 8px;
        border-radius: 8px;
        cursor: pointer;
        color: white;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
        }

        /* Tombol Edit */
        .btn-edit {
            background-color: #f1c40f; /* Biru kehijauan */
        }

        .btn-edit:hover {
            background-color: #6a691b;
        }

        /* Tombol Delete */
        .btn-delete {
            background-color: #dc3545; /* Merah */
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

       /* Style untuk tabel tanpa garis vertikal */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Header tabel rata tengah */
        .table thead th {
            text-align: center;
            background-color: #f4f4f4;
            border-bottom: 2px solid #ccc;
            color: #333;
            padding: 10px;
        }

        /* Isi tabel */
        .table tbody td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        /* Kolom ID dan Opsi tetap rata tengah */
        .table tbody td:nth-child(1),
        .table tbody td:last-child {
            text-align: center;
        }

        /* Baris genap beda warna */
        .table tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Hover efek */
        .table tr:hover {
            background-color: #f1f1f1;
        }

        /* Gambar tabel */
        .table img {
            border-radius: 6px;
        }

        /* Fasilitas */
        .table .fasilitas-list {
            list-style-type: disc;
            padding-left: 20px;
            margin: 0;
        }

        .table .fasilitas-list li {
            margin-bottom: 3px;
            line-height: 1.4;
        }

        

    </style>
@endsection

@section('content')

<div style="padding: 0 20px; width: 100%; margin: 20px;">
    <button class="toggle-sidebar" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            <div class="top-bar">
                <button class="btn-add" id="addRoomBtn">+ Tambah kamar</button>
                <div class="search-wrapper">
                    <i class='bx bx-search'></i>
                    <input type="text" class="search-input" id="searchInput" placeholder="Cari Kamar">
                </div>
            </div>
            
            <div class="main-container">
                

                <table class="table" style="width: 100%; margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kamar</th>
                            <th>Fasilitas</th>
                            <th>Gambar</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="roomTableBody">
                        @foreach ($rooms as $room)
                            <tr>
                                <td>{{ $room->id }}</td>
                                <td>{{ $room->nama }}</td>
                                <td>
                                    <ul>
                                        @foreach (is_array($room->fasilitas) ? $room->fasilitas : json_decode($room->fasilitas, true) as $fasilitas)
                                            <li>{{ $fasilitas}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    @if ($room->gambar)
                                        <img src="{{ asset('storage/' .$room->gambar) }}" width="100" alt="">    
                                    @else
                                        Tidak ada gambar
                                    @endif
                                </td>
                                <td>Rp{{ number_format($room->harga, 0, ',', '.')}}</td>
                                <td>
                                    @if ($room->status == 'kosong')
                                        <span class="badge badge-success">Kosong</span>
                                    @elseif ($room->status == 'terisi')
                                        <span class="badge badge-danger">Terisi</span>
                                    @else
                                        <span class="badge badge-danger">{{ ucfirst($room->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn-icon btn-edit"
                                        onclick="openEditModal({{ $room->id }}, '{{ $room->nama }}', '{{ implode(',', is_array($room->fasilitas) ? $room->fasilitas : json_decode($room->fasilitas)) }}', {{ $room->harga }}, '{{ $room->status }}', '{{ asset('storage/' . $room->gambar) }}')">
                                        <i class='bx bx-edit-alt'></i>
                                    </button>
                                    <form method="POST" 
                                        action="{{ route('rooms.destroy', $room->id) }}" 
                                        style="display:inline"
                                        onsubmit="return confirmDelete(event, '{{ strtolower($room->status) }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-delete">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
                <div id="pagination" style="margin-top: 1rem; text-align: center;"></div>
            </div>
        </div>    
            <div class="modal" id="roomModal">
                <div class="modal-content">
                   <form action="{{ route('rooms.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h3 id="modalTitle">Tambah Kamar</h3>
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                        <input type="text" id="roomName"  name="nama" placeholder="Nama Kamar">
                        <input type="text" id="roomFacilities" name="fasilitas" placeholder="Fasilitas (pisahkan dengan koma)">
                        <input type="number" id="roomPrice" name="harga" placeholder="Harga">
                        <input type="file" id="roomImage" name="gambar" accept="image/*">
                        <select id="roomStatus" name="status">
                            <option value="Kosong">Kosong</option>
                            <option value="Terisi">Terisi</option>
                        </select>
                        <div class="form-buttons">
                            <button  type="submit" class="btn-save" id="saveRoomBtn">Simpan</button>
                            <button class="btn-cancel" id="cancelRoomBtn">Batal</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>

        <div id="editRoomModal" class="modal">
            <div class="modal-content">
                <form id="editRoomForm" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h3>Edit Kamar</h3>
                <input type="hidden" name="property_id" value="{{ $property->id }}">
               <input type="text" id="editRoomName" name="nama" placeholder="Nama Kamar" required>

                <input type="text" id="editRoomFacilities" name="fasilitas" placeholder="Fasilitas (pisahkan dengan koma)">

                <input type="number" id="editRoomPrice" name="harga" placeholder="Harga" required>

                <select id="editRoomStatus" name="status">
                    <option value="Kosong">Kosong</option>
                    <option value="Terisi">Terisi</option>
                </select>

                <input type="file" id="editRoomImage" name="gambar" accept="image/*">

                {{-- Preview gambar lama --}}
                <div id="editRoomImagePreview" style="margin-top: 10px;">
                    <img src="" id="currentRoomImage" alt="Gambar kamar" style="max-width: 100px; display:none;">
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-save">Simpan</button>
                    <button type="button" onclick="hideEditModal()" class="btn-cancel">Batal</button>
                </div>
                </form>
            </div>
        </div>

</div>


<script>
            function openEditModal(id, nama, fasilitas, harga, status, gambarUrl) {
                const form = document.getElementById('editRoomForm');
                form.action = `/rooms/${id}`; // Ini sangat penting!

                document.getElementById('editRoomName').value = nama;
                document.getElementById('editRoomFacilities').value = fasilitas;
                document.getElementById('editRoomPrice').value = harga;
                document.getElementById('editRoomStatus').value = status.charAt(0).toUpperCase() + status.slice(1).toLowerCase();

                const previewImg = document.getElementById('currentRoomImage');
                if (gambarUrl && gambarUrl !== 'null') {
                    previewImg.src = gambarUrl;
                    previewImg.style.display = 'block';
                } else {
                    previewImg.style.display = 'none';
                }

                // document.getElementById('editRoomModal').style.display = 'block';
                document.getElementById('editRoomModal').classList.add('active');

            }

            // function hideEditModal() {
            //     document.getElementById('editRoomModal').style.display = 'none';
            // }
            function hideEditModal() {
    document.getElementById('editRoomModal').classList.remove('active');
}


            function confirmDelete(event, status) {
                if (status === 'terisi') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Kamar tidak bisa dihapus!',
                        text: 'Kamar dalam keadaan terisi dan tidak dapat dihapus.',
                        confirmButtonText: 'Oke'
                    });
                    event.preventDefault();
                    return false;
                }

                event.preventDefault();
                Swal.fire({
                    title: 'Yakin ingin menghapus kamar ini?',
                    text: "Data tidak dapat dikembalikan!",
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

                return false;
            }


</script>
<script>
            // function toggleAddModal() {
            //     const modal = document.getElementById('roomModal');
            //     modal.style.display = 'block';
            // }

            // function hideForm() {
            //     const modal = document.getElementById('roomModal');
            //     modal.style.display = 'none';
            // }

            function toggleAddModal() {
    document.getElementById('roomModal').classList.add('active');
}

function hideForm() {
    document.getElementById('roomModal').classList.remove('active');
}

            // Tambahkan event listener pada tombol
            document.addEventListener('DOMContentLoaded', function () {
                const addRoomBtn = document.getElementById('addRoomBtn');
                const cancelRoomBtn = document.getElementById('cancelRoomBtn');

                addRoomBtn.addEventListener('click', function () {
                    toggleAddModal();
                });

                cancelRoomBtn.addEventListener('click', function (e) {
                    e.preventDefault(); // Biar tidak submit form
                    hideForm();
                });
            });
            // Tutup modal jika klik luar area modal
            // window.onclick = function(event) {
            //     const modal = document.getElementById('roomModal');
            //     if (event.target === modal) {
            //         modal.style.display = 'none';
            //     }
            // }

            window.onclick = function(event) {
                const addModal = document.getElementById('roomModal');
                const editModal = document.getElementById('editRoomModal');

                if (event.target === addModal) {
                    addModal.classList.remove('active');
                }
                if (event.target === editModal) {
                    editModal.classList.remove('active');
                }
            }




            //panah
           document.addEventListener("DOMContentLoaded", function () {
            const rowsPerPage = 3;
            const tableBody = document.getElementById("roomTableBody");
            const rows = Array.from(tableBody.querySelectorAll("tr"));
            const totalPages = Math.ceil(rows.length / rowsPerPage);
            let currentPage = 1;

            function displayPage(page) {
                tableBody.innerHTML = "";
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const pageRows = rows.slice(start, end);
                pageRows.forEach(row => tableBody.appendChild(row));
                currentPage = page;
                updatePaginationButtons();
            }

            function updatePaginationButtons() {
                const paginationContainer = document.getElementById("pagination");
                paginationContainer.innerHTML = "";

                // Tombol Sebelumnya
                const prevBtn = document.createElement("button");
                prevBtn.textContent = "‹";
                prevBtn.disabled = currentPage === 1;
                prevBtn.className = "pagination-btn";
                prevBtn.addEventListener("click", () => displayPage(currentPage - 1));
                paginationContainer.appendChild(prevBtn);

                // Hanya tampilkan 5 halaman di tengah
                const maxVisible = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
                let endPage = startPage + maxVisible - 1;
                if (endPage > totalPages) {
                    endPage = totalPages;
                    startPage = Math.max(1, endPage - maxVisible + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const btn = document.createElement("button");
                    btn.textContent = i;
                    btn.className = "pagination-btn" + (i === currentPage ? " active" : "");
                    btn.addEventListener("click", () => displayPage(i));
                    paginationContainer.appendChild(btn);
                }

                // Tombol Berikutnya
                const nextBtn = document.createElement("button");
                nextBtn.textContent = "›";
                nextBtn.disabled = currentPage === totalPages;
                nextBtn.className = "pagination-btn";
                nextBtn.addEventListener("click", () => displayPage(currentPage + 1));
                paginationContainer.appendChild(nextBtn);
            }

            // Inisialisasi pertama
            displayPage(currentPage);
        });
</script>
        

   
<script>
 
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'Oke'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Oke'
            });
        @endif
    });



     
</script>


@endsection