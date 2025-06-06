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
                                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn-edit">Edit</a>
                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>    
            <div class="modal" id="roomModal">
                <div class="modal-content">
                   {{-- <form action="{{ route('rooms.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h3 id="modalTitle">Tambah Kamar</h3>
                        <input type="text" id="roomName" placeholder="Nama Kamar">
                        <input type="text" id="roomFacilities" placeholder="Fasilitas (pisahkan dengan koma)">
                        <input type="number" id="roomPrice" placeholder="Harga">
                        <input type="file" id="roomImage" accept="image/*">
                        <select id="roomStatus">
                            <option value="Kosong">Kosong</option>
                            <option value="Terisi">Terisi</option>
                        </select>
                        <div class="form-buttons">
                            <button class="btn-save" id="saveRoomBtn">Simpan</button>
                            <button class="btn-cancel" id="cancelRoomBtn">Batal</button>
                        </div>
                   </form> --}}
                </div>
            </div>
            </div>

</div>
        
@endsection