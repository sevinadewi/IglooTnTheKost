@extends('layout.master')
@section('content')
    <div class="main-container">
                <div class="top-bar">
                    <div class="search-wrapper">
                        <i class='bx bx-search'></i>
                        <input type="text" id="searchInput" placeholder="Cari Penyewa" class="search-input">
                    </div>
                    <button onclick="toogleAddModal()" class="btn-add">+ Tambah Penyewa</button>
                </div>

                <div id="tenantModal" class="modal">
                            <div class="modal-content">
                                <form action="{{ route('tenants.store')}}" method="POST">
                                    @csrf
                                    <h3 id="formTitle">Tambah Penyewa</h3>
                                    <input type="text" id="nama" name="nama" placeholder="Nama">
                                    <input type="text" id="telepon" name="telepon" placeholder="No. Telepon">
                                    <input type="date" id="tanggal" name="tanggal">
                                    
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
            

                <div id="cardsContainer" class="cards-wrapper">
                    @foreach ($tenants as $tenant)
                    <div>
                        <strong>{{ $tenant->nama }}</strong><br>
                        <i class='bx bx-phone' ></i> {{ $tenant->telepon }}<br>
                        <i class='bx bx-calendar' ></i> {{ $tenant->tanggal }}<br>
                        <i class='bx bx-bed' ></i> {{ $tenant->room->nama ?? '-' }}<br>
                        <i class='bx bx-money' ></i> Rp{{ number_format($tenant->harga, 0, ',', '.') }}
                        <div style="position:absolute; top:10px; right:10px;">
                            <a href="{{ route('tenants.edit', $tenant->id)}}"><i class='bx bx-edit-alt' ></i></button>
                            <form action="{{ route('tenants.destroy', $tenant->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus penyewa ini?')"><i class='bx bx-trash'></i></button>
                            </form>
                                
                        </div>
                        {{-- <pre>{{ dd($tenant->room) }}</pre> --}}

                    </div>
                    @endforeach
                </div>
            
                <div id="tenantModal" class="modal">
                    <div class="modal-content">
                    <h3 id="formTitle">Tambah Penyewa</h3>
                    <input type="hidden" id="editingIndex">
                    <input type="text" id="nama" placeholder="Nama">
                    <input type="text" id="telepon" placeholder="No. Telepon">
                    <input type="date" id="tanggal">
                    <input type="text" id="kamar" placeholder="Kamar">
                    <input type="text" id="harga" placeholder="Harga (cth: Rp1.000.000)">
                    <div class="form-buttons">
                        <button onclick="saveTenant()" class="btn-save">Simpan</button>
                        <button onclick="hideForm()" class="btn-cancel">Batal</button>
                    </div>
                    </div>
                </div>
            </div>
        </main>
@endsection