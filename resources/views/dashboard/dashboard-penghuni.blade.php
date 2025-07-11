@extends('layout.master')
@section('content')
<div style="padding: 0 20px; width: 100%; margin: 20px;">
    <div class="main-container">
        <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="bx bx-menu"></i>
            </button>
                <div class="top-bar">
                    <div class="search-wrapper">
                        <i class='bx bx-search'></i>
                        <input type="text" id="searchInput" placeholder="Cari Penyewa" class="search-input">
                    </div>
                    <div style="display: flex; gap: 0.75rem;">
                        <button onclick="window.location.href='{{ route('histori-penghuni', ['id' => $property->id]) }}'" class="btn-all">History Penyewa</button>
                        <button onclick="toogleAddModal()" class="btn-add">+ Tambah Penyewa</button>
                    </div>
                    
                </div>

                <div id="tenantModal" class="my-modal">
                    <div class="my-modal-content">
                        <form action="{{ route('tenants.store')}}" method="POST">
                            @csrf
                            <h3 id="formTitle">Tambah Penyewa</h3>
                            <input type="text" id="nama" name="nama" placeholder="Nama">
                            <input type="text" id="telepon" name="telepon" placeholder="No. Telepon">
                            <input type="date" id="tanggal" name="tanggal">
                            <input type="email" id="email" name="email" placeholder="email">
                            
                            <select name="room_id" id="roomSelect" required>
                                <option value="">Pilih Kamar</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id}}" data-harga="{{ $room->harga }}">{{ $room->nama }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="harga" id="hargaField" placeholder="Harga" readonly required>
                            <div class="form-buttons">
                                <button type="submit" class="btn-save">Simpan</button>
                                <button type="button" id="" onclick="hideForm('tenantModal')" class="btn-cancel">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>

                 {{-- MODAL EDIT PENYEWA --}}
                <div id="editTenantModal" class="my-modal">
                    <div class="my-modal-content">
                        <form id="editTenantForm" method="POST">
                            @csrf
                            @method('PUT')
                            <h3>Edit Penyewa</h3>
                            <input type="text" name="nama" id="editNama" placeholder="Nama" required>
                            <input type="text" name="telepon" id="editTelepon" placeholder="No. Telepon" required>
                            <input type="date" name="tanggal" id="editTanggal" required>
                            <input type="email" name="email" id="editEmail" placeholder="Email">
                            <select name="room_id" id="editRoomSelect" required>
                                <option value="">Pilih Kamar</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" data-harga="{{ $room->harga }}">{{ $room->nama }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="harga" id="editHargaField" placeholder="Harga" readonly required>
                            

                            <div class="form-buttons">
                                <button type="submit" class="btn-save">Update</button>
                                <button type="button" onclick="hideModal('editTenantModal')" class="btn-cancel">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>


            

                <div id="cardsContainer" class="cards-wrapper">
                    @foreach ($tenants as $tenant)
                    
                    <div>
                        <strong>{{ $tenant->nama }}</strong><br>
                        <i class='bx bx-phone' ></i> {{ $tenant->telepon }}<br>
                        <i class='bx bx-calendar' ></i> {{ $tenant->tanggal }}<br>
                        <i class='bx bx-bed' ></i> {{ $tenant->room->nama ?? '-' }}<br>
                        <i class='bx bx-money' ></i> Rp{{ number_format($tenant->harga, 0, ',', '.') }}
                        <div style="position:absolute; top:10px; right:10px;">
                            <button type="button"
                                onclick="openEditModal(
                                    {{ $tenant->id }},
                                    '{{ addslashes($tenant->nama) }}',
                                    '{{ addslashes($tenant->telepon) }}',
                                    '{{ $tenant->tanggal }}',
                                    '{{ addslashes($tenant->email ?? '') }}',
                                    '{{ $tenant->room_id }}'
                                )">
                                <i class='bx bx-edit-alt'></i>
                            </button>

                            <form action="{{ route('tenants.keluar', $tenant->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" onclick="return confirm('Yakin penyewa ini keluar kos?')">
                                    <i class='bx bx-log-out'></i>
                                </button>
                            </form>     
                        </div>
                        <div class="cards-footer">
                            <a href="{{ route('detail-penghuni', $tenant->id) }}">Lihat Detail</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            
            </div>
        </main>
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
        @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`
            });
        </script>
        @endif

        <script>
            // Toggle sidebar di HP (responsive)
            function toggleSidebar() {
                document.body.classList.toggle('sb-open');
            }
            function toogleAddModal() {
                const modal = document.getElementById('tenantModal');
                modal.classList.add('active');
            }

            function hideForm() {
                const modal = document.getElementById('tenantModal');
                modal.classList.remove('active');
            }

            function hideModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) modal.classList.remove('active');
            }

            // Tutup modal jika klik luar area modal
            window.onclick = function(event) {
                const modal = document.getElementById('tenantModal');
                if (event.target === modal) {
                    modal.classList.add('active');
                }
            }

            //form penyewa
            function setUpHargaOtomatis(roomSelectId = "roomSelect", hargaFieldId = "hargaField") {
                document.addEventListener("DOMContentLoaded", function () {
                    const roomSelect = document.getElementById(roomSelectId);
                    const hargaField = document.getElementById(hargaFieldId);

                    if (!roomSelect || !hargaField) return;

                    roomSelect.addEventListener("change", function () {
                        const selectedOption = this.options[this.selectedIndex];
                        const harga = selectedOption.getAttribute("data-harga");
                        hargaField.value = harga ? harga : '';
                    })
                })
            }

             // Untuk modal edit
            function openEditModal(id, nama, telepon, tanggal, email, room_id) {
                const form = document.getElementById("editTenantForm");
                form.action = `/tenants/${id}`;
                document.getElementById("editNama").value = nama;
                document.getElementById("editTelepon").value = telepon;
                document.getElementById("editTanggal").value = tanggal;
                document.getElementById("editEmail").value = email;
                 const roomSelect = document.getElementById("editRoomSelect");
    
                 const hargaField = document.getElementById("editHargaField");

    // Set selected value
    roomSelect.value = room_id;

    // Ambil harga dari option yang sesuai
    const selectedOption = roomSelect.querySelector(`option[value="${room_id}"]`);
    if (selectedOption) {
        const harga = selectedOption.getAttribute('data-harga');
        hargaField.value = harga ?? '';
    }

                document.getElementById("editTenantModal").classList.add('active');
            }

            // Jalankan fungsi saat file ini dimuat
            setUpHargaOtomatis("editRoomSelect", "editHargaField");

            
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById("searchInput");
                const cardsContainer = document.getElementById("cardsContainer");
                const cards = Array.from(cardsContainer.children);

                searchInput.addEventListener("input", function () {
                    const query = this.value.toLowerCase();

                    cards.forEach(card => {
                        const textContent = card.textContent.toLowerCase();
                        const isMatch = textContent.includes(query);
                        card.style.display = isMatch ? "" : "none";
                    });
                });
            });
        </script>

@endsection

