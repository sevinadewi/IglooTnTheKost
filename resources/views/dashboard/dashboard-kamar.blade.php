@extends('layout.master')
@section('content')

<div style="padding: 0 20px; width: 100%; margin: 20px;">
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
                                <td>{{ $room->status }}</td>
                                <td>
                                    <a href="{{ route('rooms.edit', $room->id) }}" class="icon-btn edit"><i class='bx bx-edit-alt'></i></a>
                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn delete" onclick="return confirm('Yakin ingin menghapus?')"><i class='bx bx-trash'></i></button>
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
                    <button type="button" onclick="hideForm('editRoomModal')" class="btn-cancel">Batal</button>
                </div>
                </form>
            </div>
        </div>

</div>
<script>
            function toggleAddModal() {
                const modal = document.getElementById('roomModal');
                modal.style.display = 'block';
            }

            function hideForm() {
                const modal = document.getElementById('roomModal');
                modal.style.display = 'none';
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
            window.onclick = function(event) {
                const modal = document.getElementById('roomModal');
                if (event.target === modal) {
                    modal.style.display = 'none';
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
        

        @if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let errorMessages = `{{ implode('\n', $errors->all()) }}`;

        Swal.fire({
            icon: 'error',
            title: 'Gagal Menyimpan!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonText: 'Oke'
        });
    });
</script>
@endif

@endsection