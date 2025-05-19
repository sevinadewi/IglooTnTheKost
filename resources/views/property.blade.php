<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset ('assets/css/property.css')}}">
    <title>Document</title>
</head>
<body>
     <div class="content">
            <div class="card">
                <div class="illustration">
                    <img src="https://via.placeholder.com/300x250?text=Ilustrasi" alt="Ilustrasi Properti">
                </div>

                <div class="steps">
                    <h3>Ikuti langkah-langkah ini untuk mulai mengelola properti Anda</h3>

                    <div class="step active">
                        <div class="circle">1</div>
                        Tambahkan properti pertama saya
                        <button onclick="showForm()" class="btn-add">Tambah</button>
                    </div>

                    <!-- Modal Form -->
                    <div id="formModal" class="modal" role="dialog" aria-modal="true">
                        <div class="modal-content">
                            <h3 id="formTitle">Tambah properti baru</h3>
                            <input type="hidden" id="editingIndex">
                            <div class="form-group">
                                <label for="properti">Nama Properti</label>
                                <input type="text" id="properti" placeholder="Nama Properti *">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" id="alamat" placeholder="Alamat *">
                            </div>
                            <div class="form-group">
                                <label for="kodePos">Kode Pos</label>
                                <input type="text" id="kodePos" placeholder="Kode pos *">
                            </div>
                            <div class="form-group">
                                <label for="provinsi">Provinsi</label>
                                <input type="text" id="provinsi" placeholder="Provinsi *">
                            </div>
                            <div class="form-group">
                                <label for="kotaKab">Kota/Kabupaten</label>
                                <input type="text" id="kotaKab" placeholder="Kota/Kabupaten *">
                            </div>
                            <div class="form-group">
                                <label for="kec">Kecamatan</label>
                                <input type="text" id="kec" placeholder="Kecamatan *">
                            </div>
                            <div class="form-group">
                                <label for="kel">Kelurahan</label>
                                <input type="text" id="kel" placeholder="Kelurahan *">
                            </div>
                            <div class="form-group">
                                <label for="nomor">Whatsapp Admin Properti</label>
                                <input type="text" id="nomor" placeholder="Whatsapp Admin Properti">
                            </div>

                            <div class="form-buttons">
                                <button onclick="saveTenant()" class="btn-save">Simpan</button>
                                <button onclick="hideForm()" class="btn-cancel">Batal</button>
                            </div>
                        </div>
                    </div>

                    <div class="step inactive">
                        <div class="circle">2</div>
                        Tambahkan kamar pertama saya
                        <button class="btn-add" id="addRoomBtn">Tambah</button>
                        <div class="modal" id="roomModal">
                            <div class="modal-content">
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
                            </div>
                        </div>      
                    </div>

                    <div class="step inactive">
                        <div class="circle">3</div>
                        Tambahkan penyewa pertama saya
                        <button onclick="showForm()" class="btn-add">Tambah</button>
                        <div id="formModal" class="modal">
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
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/property.js') }}"></script>
</body>
</html>