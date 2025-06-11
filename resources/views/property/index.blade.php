<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="stylesheet" href="{{asset ('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset ('assets/css/property.css')}}">
   
    <title>Document</title>
</head>
<body>
     <div class="content">
            <div class="card">
                <div class="left">
                    <div class="illustration">
                        <img src="{{ asset('assets/img/ilustrasi_kamar.svg') }}" alt="Ilustrasi Properti">

                    </div>
                </div>

                <div class="right">
                    <div class="steps">
                    <h3>Ikuti langkah-langkah ini untuk mulai mengelola properti Anda</h3>

                    {{-- Step 1: Tambah Properti --}}
                    <div class="step {{ session('currentStep', 1) > 1 ? 'inactive' : 'active' }}">
                        <div class="circle {{ session('currentStep', 1) > 1 ? 'checked' : '' }}">1</div>
                        Tambahkan properti pertama saya
                        <button onclick="showForm('propertyModal')" class="btn-add" {{ session('currentStep', 1) > 1 ? 'style=display:none;' : '' }}>Tambah</button>
                    </div>

                    <!-- Modal Form -->
                    <div id="propertyModal" class="modal" role="dialog" aria-modal="true">
                        <div class="modal-content">
                           <form action="{{ route('property.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <h3 id="formTitle">Tambah properti baru</h3>
                                {{-- <input type="hidden" id="editingIndex"> --}}
                                <div class="form-group">
                                    <label for="properti">Nama Properti</label>
                                    <input type="text" id="properti" name="properti" placeholder="Nama Properti *" value="{{ old('properti') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" id="alamat" name="alamat" placeholder="Alamat *" value="{{ old('alamat') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kodePos">Kode Pos</label>
                                    <input type="text" id="kodePos" name="kodePos" placeholder="Kode pos *" value="{{ old('kodePos') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="provinsi">Provinsi</label>
                                    <input type="text" id="provinsi" name="provinsi" placeholder="Provinsi *" value="{{ old('provinsi') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kotaKab">Kota/Kabupaten</label>
                                    <input type="text" id="kotaKab" name="kotaKab" placeholder="Kota/Kabupaten *" value="{{ old('kotaKab') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kec">Kecamatan</label>
                                    <input type="text" id="kec" name="kec" placeholder="Kecamatan *" value="{{ old('kec') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kel">Kelurahan</label>
                                    <input type="text" id="kel" name="kel" placeholder="Kelurahan *" value="{{ old('kel') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nomor">Whatsapp Admin Properti</label>
                                    <input type="text" id="nomor" name="no_wa" placeholder="Whatsapp Admin Properti" value="{{ old('no_wa') }}">
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto Kos</label>
                                    <input type="file" id="foto" name="foto"  accept="image/*">
                                </div>

                                <div class="form-buttons">
                                    <button type="submit" class="btn-save">Simpan</button>
                                    <button type="button" onclick="hideForm('propertyModal')" class="btn-cancel">Batal</button>
                                </div>
                           </form>
                        </div>
                    </div>

                    {{-- Langkah 2: Tambah Kamar --}}
                    <div class="step {{ session('currentStep', 1) < 2 ? 'inactive' : (session('currentStep', 1) > 2 ? 'inactive' : 'active') }}">
                        <div class="circle {{ session('currentStep', 1) > 2 ? 'checked' : '' }}">2</div>
                        Tambahkan kamar pertama saya
                        <button class="btn-add" id="addRoomBtn"  onclick="showForm('roomModal')" {{ session('currentStep', 1) < 2 ? 'style=display:none;' : '' }}>Tambah</button>

                        <div class="modal" id="roomModal">
                            <div class="modal-content">
                                <form action="{{ route('property.storeRoom')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <h3 id="modalTitle">Tambah Kamar</h3>
                                    <input type="hidden" name="property_id" value="{{ session('property_id') ?? '' }}">
                                    <input type="text" id="roomName" name="nama" placeholder="Nama Kamar">
                                    <input type="text" id="roomFacilities" name="fasilitas" placeholder="Fasilitas (pisahkan dengan koma)">
                                    <input type="number" id="roomPrice" name="harga" placeholder="Harga">
                                    <input type="file" id="roomImage" name="gambar" accept="image/*">
                                    <select id="roomStatus" name="status">
                                        <option value="Kosong">Kosong</option>
                                        <option value="Terisi">Terisi</option>
                                    </select>
                                    <div class="form-buttons">
                                    <button type="submit" class="btn-save"  id="saveRoomBtn">Simpan</button>
                                    <button type="button" class="btn-cancel" onclick="hideForm('roomModal')" id="cancelRoomBtn">Batal</button>
                                </div>
                                </form>
                            </div>
                        </div>      
                    </div>

                    <div class="step {{ session('currentStep', 1) < 3 ? 'inactive' : (session('currentStep', 1) > 3 ? 'inactive' : 'active') }}">
                        <div class="circle {{ session('currentStep', 1) > 3 ? 'checked' : ''}}">3</div>
                        Tambahkan penyewa pertama saya
                        <button onclick="showForm('tenantModal')" class="btn-add" {{ session('currentStep', 1) < 3 ? 'style=display:none;' : ''}}>Tambah</button>
                        
                        <div id="tenantModal" class="modal">
                            <div class="modal-content">
                                <form action="{{ route('property.storeTenant')}}" method="POST">
                                    @csrf
                                    <h3 id="formTitle">Tambah Penyewa</h3>
                                    <input type="hidden" id="editingIndex">
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
                        
                    </div>
                </div>
                </div>
                

                
            </div>
        </div>

        {{-- @if (session('lanjut') == 'kamar')
        <script>
            window.onload = function() {
                let steps = document.querySelectorAll('.step');
                steps[1].classList.remove('inactive');

            }
        </script> --}}

        <script src="{{ asset('assets/js/property.js') }}"></script>
</body>
</html>